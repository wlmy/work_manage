@extends('header')
@section('styles')
    <link rel="stylesheet" href="{{asset('static/editormd-log/css/editormd.css')}}"/>
    <link rel="shortcut icon" href="https://pandao.github.io/editor.md/favicon.ico" type="image/x-icon"/>
    <link href="{{asset('static/styles/wiki.css')}}" rel="stylesheet">
    <link href="{{asset('static/webuploader/webuploader.css')}}" rel="stylesheet">
    <link href="{{asset('static/cropper/cropper.css')}}" rel="stylesheet">
    <link href="{{asset('static/bootstrap-wysiwyg/css/index.css')}}" rel="stylesheet">
    <link rel="apple-touch-icon" href="//mindmup.s3.amazonaws.com/lib/img/apple-touch-icon.png" />
    <link rel="shortcut icon" href="http://mindmup.s3.amazonaws.com/lib/img/favicon.ico" >
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('/static/cropper/cropper.js')}}"></script>
    <script type="text/javascript" src="{{asset('/static/webuploader/webuploader.js')}}"></script>
    <script src="{{asset('static/bootstrap-wysiwyg/js/bootstrap-wysiwyg.js')}}"></script>
    <script src="{{asset('static/bootstrap-wysiwyg/external/jquery.hotkeys.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            function initToolbarBootstrapBindings() {
                var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                        'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                        'Times New Roman', 'Verdana'],
                    fontTarget = $('[title=Font]').siblings('.dropdown-menu');
                $.each(fonts, function (idx, fontName) {
                    fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
                });
                $('a[title]').tooltip({container:'body'});
                $('.dropdown-menu input').click(function() {return false;})
                    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
                    .keydown('esc', function () {this.value='';$(this).change();});

                $('[data-role=magic-overlay]').each(function () {
                    var overlay = $(this), target = $(overlay.data('target'));
                    overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
                });
                if ("onwebkitspeechchange"  in document.createElement("input")) {
                    var editorOffset = $('#editor').offset();
                    $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
                } else {
                    $('#voiceBtn').hide();
                }
            };
            function showErrorAlert (reason, detail) {
                var msg='';
                if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
                else {
                    console.log("error uploading file", reason, detail);
                }
                $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
                    '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
            };
            initToolbarBootstrapBindings();
            $('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
            $('#editor').html("<?php echo 'eee'?>");
            $('#editor1').html("<?php echo 'd'?>");
            $('#add_save').on('click',function(){
                $('#editor_content').val($('#editor').html());
                $('#log_form').ajaxSubmit({
                    success : function (res) {
                        if(res.errcode == 0){
                            window.location.href=res.data['url'];
                        }else{
                            showError(res.message);
                        }
                    }
                });
            });

            function showError($msg) {
                $("#error-message").addClass("error-message").removeClass("success-message").text($msg);
                return false;
            }

            function showSuccess($msg) {
                $("#error-message").addClass("success-message").removeClass("error-message").text($msg);
                return true;
            }

        });



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
        <form method="post" action="{{route('workLog.createOrUpdateData')}}" id="log_form">
            <div style="height: 200px">
                    <!-- editor-->
                    <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="icon-font"></i><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:'Comic Sans MS'">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:'Helvetica'">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:'Impact'">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:'Lucida Grande'">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:'Lucida Sans'">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:'Tahoma'">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:'Times'">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:'Times New Roman'">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:'Verdana'">Verdana</a></li></ul>
                        </div>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                                <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                                <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                            <a class="btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
                            <a class="btn" data-edit="strikethrough" title="" data-original-title="Strikethrough"><i class="icon-strikethrough"></i></a>
                            <a class="btn" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="icon-list-ul"></i></a>
                            <a class="btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="icon-list-ol"></i></a>
                            <a class="btn" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
                            <a class="btn" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="icon-indent-right"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn btn-info" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
                            <a class="btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
                            <a class="btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
                            <a class="btn" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="icon-link"></i></a>
                            <div class="dropdown-menu input-append">
                                <input class="span2" placeholder="URL" type="text" data-edit="createLink">
                                <button class="btn" type="button">Add</button>
                            </div>
                            <a class="btn" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="icon-cut"></i></a>

                        </div>

                        <div class="btn-group">
                            <a class="btn" title="" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="icon-picture"></i></a>
                            <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 41px; height: 30px;">
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="undo" title="" data-original-title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                            <a class="btn" data-edit="redo" title="" data-original-title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
                        </div>
                        <div class="btn-group">
                            <a class="btn" data-edit="save" id="add_save" title="" data-original-title="save (Ctrl+S)"><i class="fa fa-save"></i></a>
                        </div>
                        <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="" style="display: none;">
                    </div>
                    <div id="editor" contenteditable="true"  style="height: 130px;width: 99%">
                    </div>
                    <div>
                        <textarea type="text"  name="editor_content" id="editor_content" maxlength="20"  placeholder="" hidden></textarea>
                    </div>
                </div>

        </form>

        @foreach($logLists as $key => $val)
        <div class="split">
            @if(substr($val['create_time'], 0, 10) == date('Y-m-d', time()))
                <dt>今天</dt>
            @elseif(substr($val['create_time'], 0, 10) == date('Y-m-d', strtotime("-1 day")))
                <dt>昨天</dt>
            @elseif(substr($val['create_time'], 0 ,10) == date('Y-m-d', strtotime("-2 day")))
                <dt>前天</dt>
            @else
                <dt1>&nbsp;</dt1>
            @endif



            <div class="list-container">
                <div class="log-user">
                    <div class="name-content">
                        <div class="log-user-name">{{$val['account']}}</div>
                        <div style="margin-top: 10px">
                            <div id="editor1" contenteditable="true"  style="height: 130px;width: 99%">
                            </div>
                            </div>
                    </div>
                </div>

                <div class="date">{{$val['create_time']}}</div>
                <div class="btn-box">
                    <a href="/work/edit?id=2" class="log-alter">&nbsp;<i class="fa fa-pencil">&nbsp;</i></a>
                </div>
            </div>
        </div>
        @endforeach

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
            height: 300,
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
            toolbarIcons: ["new", "new-template", "template", "save", "undo", "redo", "h1", "h2", "h3", "h4", "bold", "hr", "italic", "quote", "list-ul", "list-ol", "link", "reference-link", "image", "code", "html-entities", "preformatted-text", "code-block", "table"],
            toolbarIconsClass: {
                bold: "fa-bold"
            },
            toolbarIconTexts: {
                bold: 'a'
            },
            toolbarCustomIcons: {
                new: '<a href="javascript:;" title="写日报" id="markdown-new" class="disabled"> <i class="fa fa-edit" name="new"></i></a>',
                'new-template' : '<a href="javascript:;" title="新增模板"> <i class="fa fa-file-text" name="new_template"></i></a>',
                template : '<a href="javascript:;" title="配置默认模板"> <i class="fa fa-tachometer" name="template"></i></a>',
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
                template : function(cm, icon, cursor, selection) {
                    $("#template-modal").modal('show');
                }
            },
            onchange : function () {
                if(testEditor.isEditorChange) {
                    testEditor.isEditorChange = false;
                }else{
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

