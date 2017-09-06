@extends('member')
@section('title')写日志@endsection
@section('styles')
    <link href="{{asset('static/log/write.css')}}" rel="stylesheet">
    <link href="{{asset('static/webuploader/webuploader.css')}}" rel="stylesheet">
    <link href="{{asset('static/cropper/cropper.css')}}" rel="stylesheet">
    <style type="text/css">
        #upload-logo-panel .wraper{
            float: left;
            background: #f6f6f6;
            position: relative;
            width: 360px;
            height: 360px;
            overflow: hidden;
        }
        #upload-logo-panel .watch-crop-list{
            width: 170px;
            padding:10px 20px;
            margin-left: 10px;
            background-color: #f6f6f6;
            text-align: center;
            float: right;
            height: 360px;
        }
        #image-wraper{
            text-align: center;
        }
        .webuploader-pick{

        }
        .webuploader-pick-hover{

        }
        .webuploader-container{
            padding: 0;
            border: 0;
            height: 40px;
        }
        .watch-crop-list>ul{
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .webuploader-container div{
            width: 77px !important;
            height: 40px !important;
            left: 0 !important;
        }
        .img-preview {
            margin: 5px auto 10px auto;
            text-align: center;
            overflow: hidden;
        }
        .img-preview > img {
            max-width: 100%;
        }
        .preview-lg{
            width: 120px;
            height: 120px;
        }
        .preview-sm{
            width: 60px;
            height: 60px;
        }
        #error-message{
            font-size: 13px;
            color: red;
            vertical-align: middle;
            margin-top: -10px;
            display: inline-block;
            height: 40px;
        }
    </style>
@endsection
@section('scripts')
<script type="text/javascript" src="/static/cropper/cropper.js"></script>
<script type="text/javascript" src="/static/webuploader/webuploader.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("input[type='radio']").click(function () {
            var radio_val = $("input[type='radio']:checked").val();
            if (radio_val === '0') {
                $("#daily").show();
            }else{
                $("#daily").hide();
            }

            if (radio_val === '1') {
                $("#week").show();
            }else{
                $("#week").hide();
            }

            if (radio_val === '2') {
                $("#month").show();
            }else{
                $("#month").hide();
            }

            if (radio_val === '3') {
                $("#year").show();
            }else{
                $("#year").hide();
            }
        });
    });


    $(function () {
        var modalHtml = $("#upload-logo-panel").find(".modal-body").html();

        $("#upload-logo-panel").on("hidden.bs.modal",function () {
            $("#upload-logo-panel").find(".modal-body").html(modalHtml);
        });

        $("#basic-form").ajaxForm({
            beforeSubmit : function () {

                var email = $.trim($("#user-email").val());
                if(!email){
                    return showError('邮箱不能为空');
                }

            },
            success : function (res) {
                if(res.errcode == 0){
                    showSuccess("保存成功");
                }else{
                    showError(res.message);
                }
            }
        });
    });
    try {
        var uploader = WebUploader.create({
            auto: false,
            swf: '/static/webuploader/Uploader.swf',
            server: '{{route('member.upload')}}',
            pick: "#filePicker",
            fileVal : "image-file",
            fileNumLimit : 1,
            compress : false,
            accept: {
                title: 'Images',
                extensions: 'jpg,jpeg,png',
                mimeTypes: 'image/jpg,image/jpeg,image/png'
            }
        }).on("beforeFileQueued",function (file) {
            uploader.reset();
        }).on( 'fileQueued', function( file ) {
            uploader.makeThumb( file, function( error, src ) {
                $img = '<img src="' + src +'" style="max-width: 360px;max-height: 360px;">';
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $("#image-wraper").html($img);
                window.ImageCropper = $('#image-wraper>img').cropper({
                    aspectRatio: 1 / 1,
                    dragMode : 'move',
                    viewMode : 1,
                    preview : ".img-preview"
                });
            }, 1, 1 );
        }).on("uploadError",function (file,reason) {
            console.log(reason);
            $("#error-message").text("上传失败:" + reason);

        }).on("uploadSuccess",function (file, res) {

            if(res.success == 1){
                console.log(res);
                $("#upload-logo-panel").modal('hide');
                $("#headimgurl").attr('src',res.url);
                $("input[name='imgUrl']").val(res.url);
            }else{
                $("#error-message").text(res.message);
            }
        }).on("beforeFileQueued",function (file) {
            if(file.size > 1024*1024*2){
                uploader.removeFile(file);
                uploader.reset();
                alert("文件必须小于2MB");
                return false;
            }
        }).on("uploadComplete",function () {
            $("#saveImage").button('reset');
        });
        $("#saveImage").on("click",function () {
            var files = uploader.getFiles();
            if(files.length > 0) {
                $("#saveImage").button('loading');
                var cropper = window.ImageCropper.cropper("getData");

                uploader.option("formData", cropper);

                uploader.upload();
            }else{
                alert("请选择图片");
            }
        });
    }catch(e){
        console.log(e);
    }
</script>
@endsection
@section('content')
    <div class="member-box">
        <div class="box-head">
            <h4>写日志</h4>
        </div>
        <div class="box-body">
            <form role="form" class="form-horizontal col-sm-5" method="post" action="{{route('workLog.createOrUpdateData')}}" id="account-form">
                <div class="form-group" style="margin-right: -150px">
                    <label style="margin-right: 15px;">
                        <li style="list-style: none"><img src="/static/images/log/ri.png" style="width: 80px;height: 80px"/></li>
                        <li style="list-style: none"><input type="radio" name="workLogType" value="0" checked="">日报</li>
                    </label>
                    <label style="margin-right: 15px;">
                        <li style="list-style: none"><img src="/static/images/log/zhou.png" style="width: 80px;height: 80px"/></li>
                        <li style="list-style: none"><input type="radio" name="workLogType" value="1">周报</li>
                    </label>&nbsp;&nbsp;
                    <label style="margin-right: 15px;">
                        <li style="list-style: none"><img src="/static/images/log/yue.png" style="width: 80px;height: 80px"/></li>
                        <li style="list-style: none"><input type="radio" name="workLogType" value="2">月报</li>
                    </label>&nbsp;&nbsp;
                    <label style="margin-right: 15px;">
                        <li style="list-style: none"><img src="/static/images/log/nian.png" style="width: 80px;height: 80px"/></li>
                        <li style="list-style: none"><input type="radio" name="workLogType" value="3">年计划</li>
                    </label>
                </div>
                <div id="daily">
                    <div class="form-group">
                        <label for="todayFinished">今日完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayFinished" id="todayFinished" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="todayUnFinished">未完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayUnFinished" id="todayUnFinished" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="todayConcerted">需协调工作</label>
                        <input type="text" class="form-control" name="todayConcerted" id="todayConcerted" maxlength="20" placeholder="" value="">
                    </div>
                </div>


                <div id="week" hidden>
                    <div class="form-group">
                        <label for="weekFinished">本周完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="weekFinished" id="weekFinished" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="weekSummary">本周工作总结</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="weekSummary" id="weekSummary" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="nextWeekPlan">下周工作计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="nextWeekPlan" id="nextWeekPlan" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="weekConcerted">需协调与帮助</label>
                        <input type="text" class="form-control" name="weekConcerted" id="weekConcerted" maxlength="20" placeholder="" value="">
                    </div>
                </div>


                <div id="month" hidden>
                    <div class="form-group">
                        <label for="monthFinished">本月工作内容</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="monthFinished" id="monthFinished" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="monthSummary">本月工作总结</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="monthSummary" id="monthSummary" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="nextMonthPlan">下月工作计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="nextMonthPlan" id="nextMonthPlan" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="monthConcerted">需帮助与支持</label>
                        <input type="text" class="form-control" name="monthConcerted" id="monthConcerted" maxlength="20" placeholder="" value="">
                    </div>
                </div>

                <div id="year" hidden>
                    <div class="form-group">
                        <label for="yearTarget">今年目标</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearTarget" id="yearTarget" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="yearPlan">关键计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearPlan" id="yearPlan" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="yearFinishSituation">完成情况</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearFinishSituation" id="yearFinishSituation" maxlength="20" placeholder="" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="remark">备注</label>
                    <textarea class="form-control" rows="3" title="描述" name="remark" id="remark" maxlength="500"></textarea>
                </div>
                <div class="form-group">
                    <label for="img">图片</label>
                    <label>
                        <input type="text" hidden name="imgUrl" value="">
                        <a href="javascript:;" data-toggle="modal" data-target="#upload-logo-panel">
                            <img src="/static/images/plus.png" onerror="this.src='/static/images/middle.gif'" class="img-circle" alt="图片" style="max-width: 50px;max-height: 50px;" id="headimgurl">
                        </a>
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">提交</button>
                    <span id="error-message"></span>
                </div>
            </form>
        </div>
    </div>

    <!--附件上传-->
    <div class="modal fade" id="upload-logo-panel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">图片</h4>
                </div>
                <div class="modal-body">
                    <div class="wraper">
                        <div id="image-wraper">

                        </div>
                    </div>
                    <div class="watch-crop-list">
                        <div class="preview-title">预览</div>
                        <ul>
                            <li>
                                <div class="img-preview preview-lg"></div>
                            </li>
                            <li>
                                <div class="img-preview preview-sm"></div>
                            </li>
                        </ul>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="modal-footer">
                    <span id="error-message"></span>
                    <div id="filePicker" class="btn">选择</div>
                    <button type="button" id="saveImage" class="btn btn-success" style="height: 40px;width: 77px;" data-loading-text="上传中...">上传</button>
                </div>
            </div>
        </div>
    </div>
@endsection