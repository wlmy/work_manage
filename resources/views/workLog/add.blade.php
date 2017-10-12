@extends('header')
@section('styles')
    <link rel="stylesheet" href="{{asset('static/editormd-log/css/editormd.css')}}"/>
    <link rel="shortcut icon" href="https://pandao.github.io/editor.md/favicon.ico" type="image/x-icon"/>
    <link href="{{asset('static/styles/wiki.css')}}" rel="stylesheet">
    <link href="{{asset('static/webuploader/webuploader.css')}}" rel="stylesheet">
    <link href="{{asset('static/cropper/cropper.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('/static/cropper/cropper.js')}}"></script>
    <script type="text/javascript" src="{{asset('/static/webuploader/webuploader.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            var modalHtml = $("#upload-logo-panel").find(".modal-body").html();

            $("#upload-logo-panel").on("hidden.bs.modal", function () {
                $("#upload-logo-panel").find(".modal-body").html(modalHtml);
            });

            $("#basic-form").ajaxForm({
                beforeSubmit: function () {

                    var email = $.trim($("#user-email").val());
                    if (!email) {
                        return showError('邮箱不能为空');
                    }

                },
                success: function (res) {
                    if (res.errcode == 0) {
                        showSuccess("保存成功");
                    } else {
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
                fileVal: "image-file",
                fileNumLimit: 1,
                compress: false,
                accept: {
                    title: 'Images',
                    extensions: 'jpg,jpeg,png',
                    mimeTypes: 'image/jpg,image/jpeg,image/png'
                }
            }).on("beforeFileQueued", function (file) {
                uploader.reset();
            }).on('fileQueued', function (file) {
                uploader.makeThumb(file, function (error, src) {
                    $img = '<img src="' + src + '" style="max-width: 360px;max-height: 360px;">';
                    if (error) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    $("#image-wraper").html($img);
                    window.ImageCropper = $('#image-wraper>img').cropper({
                        aspectRatio: 1 / 1,
                        dragMode: 'move',
                        viewMode: 1,
                        preview: ".img-preview"
                    });
                }, 1, 1);
            }).on("uploadError", function (file, reason) {
                console.log(reason);
                $("#error-message").text("上传失败:" + reason);

            }).on("uploadSuccess", function (file, res) {

                if (res.success == 1) {
                    console.log(res);
                    $("#upload-logo-panel").modal('hide');
                    $("#headimgurl").attr('src', res.url);
                } else {
                    $("#error-message").text(res.message);
                }
            }).on("beforeFileQueued", function (file) {
                if (file.size > 1024 * 1024 * 2) {
                    uploader.removeFile(file);
                    uploader.reset();
                    alert("文件必须小于2MB");
                    return false;
                }
            }).on("uploadComplete", function () {
                $("#saveImage").button('reset');
            });
            $("#saveImage").on("click", function () {
                var files = uploader.getFiles();
                if (files.length > 0) {
                    $("#saveImage").button('loading');
                    var cropper = window.ImageCropper.cropper("getData");

                    uploader.option("formData", cropper);

                    uploader.upload();
                } else {
                    alert("请选择头像");
                }
            });
        } catch (e) {
            console.log(e);
        }
    </script>
@endsection

@section('content')
    <div class="main-content">
        <form method="post" action="{{route('workLog.createOrUpdateData')}}" id="form-editormd">
            <div id="layout">
                <div id="test-editormd">
                   <textarea style="display:none;">
##### 成果和收获:
  - Emoji;
 @@ -18,67 +128,361 @@
      lib/
      css/

#####错误和不足之处:
  - Emoji;
 @@ -18,67 +128,361 @@
                   </textarea>
                </div>
            </div>
        </form>




    </div>
    <div class="user-login-info">
        <div class="user-info">
            <div class="username"><label>
                    <a href="javascript:;" data-toggle="modal" data-target="#upload-logo-panel">
                        <img src="{{$member->headimgurl}}" onerror="this.src='/static/images/middle.gif'"
                             class="img-circle" alt="头像" style="max-width: 50px;max-height: 50px;" id="headimgurl">
                    </a>
                </label><span style="margin-left: 12px">wulimin</span></div>
            <div style="color: #999;font-size: 12px; margin-top: 10px"><label>最近登录：</label>2017-09-18 17:30</div>
            <div style="color: #999;font-size: 12px;"><label>登录次数：</label>2</div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="upload-logo-panel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">修改头像</h4>
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
                    <button type="button" id="saveImage" class="btn btn-success" style="height: 40px;width: 77px;"
                            data-loading-text="上传中...">上传
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="template-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="modal-title">请设置模板</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="section">
                            <a data-type="normal" href="javascript:;"><i class="fa fa-file-o"></i></a>
                            <h3><a data-type="normal" href="javascript:;">普通文档</a></h3>
                            <ul>
                                <li>默认类型</li>
                                <li>简单的文本文档</li>
                            </ul>
                        </div>
                        <div class="section">
                            <a data-type="api" href="javascript:;"><i class="fa fa-file-code-o"></i></a>
                            <h3><a data-type="normal" href="javascript:;">API文档</a></h3>
                            <ul>
                                <li>用于API文档速写</li>
                                <li>支持代码高亮</li>
                            </ul>
                        </div>
                        <div class="section">
                            <a data-type="code" href="javascript:;"><i class="fa fa-book"></i></a>

                            <h3><a data-type="code" href="javascript:;">数据字典</a></h3>
                            <ul>
                                <li>用于数据字典显示</li>
                                <li>表格支持</li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>

@endsection

<script src="{{asset('static/editormd-log/js/jquery.min.js')}}"></script>
<script src="{{asset('static/editormd-log/js/editormd.min.js')}}"></script>
<script type="text/javascript">
    var testEditor;
    $(function () {
        testEditor = editormd("test-editormd", {
            width: "100%",
            height: 700,
            syncScrolling: "single",
            path: "/static/editormd-log/lib/",
            imageUpload: true,
            imageFormats: ["jpg", "jpeg", "gif", "png", "JPG", "JPEG", "GIF", "PNG"],
            imageUploadURL: "/upload",
            fileUpload: true,
            htmlDecode: true,
            fileUploadURL: '/upload',
            tocStartLevel: 1,
            tocm: true,
            //toolbarIcons: ["new", "new-template", "template", "save", "undo", "redo", "h1", "h2", "h3", "h4", "bold", "hr", "italic", "quote", "list-ul", "list-ol", "link", "reference-link", "image", "code", "html-entities", "preformatted-text", "code-block", "table"],
            toolbarIcons: ["save", "undo", "redo", "h1", "h2", "h3", "h4", "bold", "hr", "italic", "quote", "list-ul", "list-ol", "link", "reference-link", "image", "code", "html-entities", "preformatted-text", "code-block", "table"],
            toolbarIconsClass: {
                bold: "fa-bold"
            },
            toolbarIconTexts: {
                bold: 'a'
            },
            toolbarCustomIcons: {
                new: '<a href="javascript:;" title="写日报" id="markdown-new" class="disabled"> <i class="fa fa-edit" name="new"></i></a>',
                'new-template': '<a href="javascript:;" title="新增模板"> <i class="fa fa-file-text" name="new_template"></i></a>',
                template: '<a href="javascript:;" title="配置默认模板"> <i class="fa fa-tachometer" name="template"></i></a>',
                save: '<a href="javascript:;" title="保存" id="markdown-save" class="disabled"> <i class="fa fa-save" name="save"></i></a>',
            },
            toolbarHandlers: {
                new: function (cm, icon, cursor, selection) {
                    testEditor.syncScrolling = "single";


                },
                save: function (cm, icon, cursor, selection) {
                    if ($("#markdown-save").hasClass('change')) {
                        $("#form-editormd").submit();
                    }
                },
                template: function (cm, icon, cursor, selection) {
                    $("#template-modal").modal('show');
                }
            },
            onchange: function () {
                if (testEditor.isEditorChange) {
                    testEditor.isEditorChange = false;
                } else {
                    $("#markdown-save").removeClass('disabled').addClass('change');
                }
            }
        });

        /**
         * 实现保存文档编辑
         */
        $("#form-editormd").ajaxForm({
            dataType: "json",
            beforeSubmit: function (formData, jqForm, options) {
                $("#markdown-save").removeClass('change').addClass('disabled');
                var content = $.trim(testEditor.getMarkdown());

                if (content === "") {
                    layer.msg("保存成功");
                    return false;
                }

                layerIndex = layer.load(1, {
                    shade: [0.1, '#fff'] //0.1透明度的白色背景
                });
            },
            success: function (res) {
                if (res.errcode === 0) {
                    $("#markdown-save").removeClass('change').addClass('disabled');
                    layer.close(layerIndex);
                    layer.msg("文档已保存");
                } else {
                    $("#markdown-save").removeClass('disabled').addClass('change');
                    layer.msg(res.message);
                }
            }
        });
    });
</script>

