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
- Task lists;

##### 错误和不足之处：
    editor.md/
    lib/
    css/
</textarea>
            </div>
        </div>
        </form>
        <div class="split">
            <dt>今天</dt>
            <div class="list-container">
                <div class="log-user">
                    <div class="name-content">
                        <div class="log-user-name">wulimin</div>
                        <div>坎坎坷坷扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩llllllllllllllllllllllll</div>
                    </div>
                </div>

                <div class="date">2017-05-25 12:20:23</div>
                <div class="btn-box">
                    <a href="/work/edit?id=2" class="log-alter">&nbsp;<i class="fa fa-pencil">&nbsp;</i></a>
                </div>
            </div>
        </div>

        <div class="split">
            <dt>昨天</dt>
            <div class="list-container">
                <div class="log-user">
                    <div class="name-content">
                        <div class="log-user-name">wulimin</div>
                        <div>坎坎坷坷扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩扩llllllllllllllllllllllll</div>
                    </div>
                </div>

                <div class="date">2017-05-25 12:20:23</div>
                <div class="btn-box">
                    <a href="/work/edit?id=2" class="log-alter">&nbsp;<i class="fa fa-pencil">&nbsp;</i></a>
                </div>
            </div>
        </div>


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
    <script type="text/plain" id="template-normal">
##SmartWiki是什么?
一个文档储存系统。

##SmartWiki有哪些功能？

-  项目管理
-  文档管理
-  用户管理
-  用户权限管理
-  项目加密
-  站点配置

##有问题反馈
在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(longfei6671#163.com, 把#换成@)
* QQ: 867311066
* http://www.iminho.me

##捐助开发者
在兴趣的驱动下,写一个`免费`的东西，有欣喜，也还有汗水，希望你喜欢我的作品，同时也能支持一下。
当然，有钱捧个钱场（右上角的爱心标志，支持支付宝捐助），没钱捧个人场，谢谢各位。

##感激
感谢以下的项目,排名不分先后

- laravel 5.2
- mysql 5.6
- editor.md
- bootstrap 3.2
- jquery 库
- layer 弹出层框架
- webuploader 文件上传框架
- Nprogress 库
- jstree
- font awesome 字体库
- cropper 图片剪裁库

##关于作者

一个纯粹的PHPer.
PS：PHP是世界上最好的语言，没有之一(逃
</script>
    <script type="text/plain" id="template-api">
### 简要描述：

- 用户登录接口

### 请求域名:

- http://xx.com

### 请求URL:

GET:/api/login

POST:/api/login

PUT:/api/login

DELETE:/api/login

TRACE:/api/login


### 参数:

|参数名|是否必须|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |

### 返回示例:

**正确时返回:**

```
  {
    "errcode": 0,
    "data": {
      "uid": "1",
      "account": "admin",
      "nickname": "Minho",
      "group_level": 0 ,
      "create_time": "1436864169",
      "last_login_time": "0",
    }
  }
```

**错误时返回:**


```
  {
    "errcode": 500,
    "errmsg": "invalid appid"
  }
```

### 返回参数说明:

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|group_level |int   |用户组id，1：超级管理员；2：普通用户  |

### 备注:

- 更多返回错误代码请看首页的错误代码描述



</script>
    <script type="text/plain" id="template-code">
### 数据库字典
#### 用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

#### 备注：无



</script>


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

