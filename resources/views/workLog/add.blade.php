@extends('member')
@section('title')写日志@endsection
@section('styles')
    <link href="{{asset('static/log/write.css')}}" rel="stylesheet">
    <link href="{{asset('static/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">


    <link href="{{asset('static/bootstrap-wysiwyg/css/index.css')}}" rel="stylesheet">
    <link rel="apple-touch-icon" href="//mindmup.s3.amazonaws.com/lib/img/apple-touch-icon.png" />
    <link rel="shortcut icon" href="http://mindmup.s3.amazonaws.com/lib/img/favicon.ico" >
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">

@endsection
@section('scripts')
    <script src="{{asset('static/bootstrap-wysiwyg/js/bootstrap-wysiwyg.js')}}"></script>
    <script src="{{asset('static/bootstrap-wysiwyg/external/jquery.hotkeys.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("input[type='radio']").click(function () {
                var radio_val = $("input[type='radio']:checked").val();
                if (radio_val === '0') {
                    $("#daily").show();
                } else {
                    $("#daily").hide();
                }

                if (radio_val === '1') {
                    $("#week").show();
                } else {
                    $("#week").hide();
                }

                if (radio_val === '2') {
                    $("#month").show();
                } else {
                    $("#month").hide();
                }

                if (radio_val === '3') {
                    $("#year").show();
                } else {
                    $("#year").hide();
                }
            });
        });

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
            $('#submit').on('click',function(){
                $('#editor_content').val($('#editor').html())
                $('#account-form').submit();
            })

        });
    </script>
@endsection
@section('content')
    <div class="setting-box">
        <div class="box-head">
            <h4>写日志</h4>
        </div>
        <div class="box-data">
            <form role="form" class="add_form" method="post"
                  action="{{route('workLog.createOrUpdateData')}}" id="account-form">
                {{--<div class="log-type">
                    <div class="log-type-box">
                        <div><img src="/static/images/log/ri.png"/></div>
                        <div><input type="radio" name="workLogType" value="0" checked="">日报</div>
                    </div>
                    <div class="log-type-box">
                        <div><img src="/static/images/log/zhou.png"/></div>
                        <div><input type="radio" name="workLogType" value="1">周报</div>
                    </div>
                    <div class="log-type-box">
                        <div><img src="/static/images/log/yue.png"/></div>
                        <div><input type="radio" name="workLogType" value="2">月报</div>
                    </div>
                    <div class="log-type-box">
                        <div><img src="/static/images/log/nian.png"/></div>
                        <div><input type="radio" name="workLogType" value="3">年计划</div>
                    </div>
                </div>--}}
                <div id="daily">
                    <div>
                        <p>今日完成工作<span id="necessary">*</span></p>
                        <textarea type="text"  name="todayFinished" id="todayFinished" maxlength="20"  placeholder=""></textarea>
                    </div>
                    <div>
                        <p>未完成工作<span>*</span></p>
                        <textarea type="text"  name="todayUnFinished" id="todayUnFinished" maxlength="20"  placeholder=""></textarea>
                    </div>
                    <div>
                        <p>需协调工作</p>
                        <textarea type="text"  name="todayConcerted" id="todayConcerted" maxlength="20"  placeholder=""></textarea>
                    </div>
                </div>


                <div id="week" hidden>
                    <div>
                        <p>本周完成工作<span>*</span></p>
                        <textarea type="text"  name="weekFinished" id="weekFinished" maxlength="20"  placeholder=""></textarea>
                    </div>
                    <div>
                        <p>本周工作总结<span>*</span></p>
                        <textarea type="text"  name="weekSummary" id="weekSummary" maxlength="20"  placeholder=""></textarea>
                    </div>
                    <div>
                        <p>下周工作计划<span>*</span></p>
                        <textarea type="text"  name="nextWeekPlan" id="nextWeekPlan" maxlength="20"  placeholder=""></textarea>
                    </div>
                    <div>
                        <p>需协调与帮助</p>
                        <textarea type="text"  name="weekConcerted" id="weekConcerted" maxlength="20"  placeholder=""></textarea>
                    </div>
                </div>


                <div id="month" hidden>
                    <div>
                        <p>本月工作内容<span>*</span></p>
                        <textarea type="text"  name="monthFinished" id="monthFinished" maxlength="20"  placeholder=""></textarea>
                    </div>
                    <div>
                        <p>本月工作总结<span>*</span></p>
                        <textarea type="text"  name="monthSummary" id="monthSummary" maxlength="20"  placeholder=""></textarea>
                    </div>
                    <div>
                        <p>下月工作计划<span>*</span></p>
                        <textarea type="text"  name="nextMonthPlan" id="nextMonthPlan" maxlength="20"  placeholder=""></textarea>
                    </div>
                    <div>
                        <p>需帮助与支持<span>*</span></p>
                        <textarea type="text"  name="monthConcerted" id="monthConcerted" maxlength="20"  placeholder=""></textarea>
                    </div>
                </div>

                <div id="year" hidden>
                    <div>
                        <p>今年目标<span>*</span></p>
                        <textarea type="text"  name="yearTarget" id="yearTarget" maxlength="20"  placeholder=""></textarea>
                    </div>
                    <div>
                        <p>关键计划<span>*</span></p>
                        <textarea type="text"  name="yearPlan" id="yearPlan" maxlength="20"  placeholder=""></textarea>
                    </div>
                    <div>
                        <p>完成情况<span>*</span></p>
                        <textarea type="text"  name="yearFinishSituation" id="yearFinishSituation" maxlength="20"  placeholder=""></textarea>
                    </div>
                </div>

                <div>
                    <div>
                        <p style="width: 90px">工作总结</p>
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
                            <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="" style="display: none;">
                        </div>
                        <div id="editor" contenteditable="true" style="margin-left: 110px">
                        </div>
                        <div>
                            <textarea type="text"  name="editor_content" id="editor_content" maxlength="20"  placeholder="" hidden></textarea>
                        </div>


                    </div>

                </div>

                <div class="btn-submit" style="margin-left: 110px;margin-top: 40px">
                    <button id="submit" class="btn btn-success">提交</button>
                    <span id="error-message"></span>
                </div>
            </form>
        </div>
    </div>
@endsection