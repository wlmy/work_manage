@extends('header')
@section('styles')
    <link href="{{asset('static/log/write.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('static/editormd-log/css/write.css')}}" />
    <link rel="stylesheet" href="{{asset('static/editormd-log/css/editormd.css')}}" />
    <link rel="shortcut icon" href="https://pandao.github.io/editor.md/favicon.ico" type="image/x-icon" />
@endsection
@section('content')
<div class="main-content">
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
    <div class="split"><dt>今天</dt>
        <div class="list-container">
            <div class="log-user">
                <div class="name-content">
                    <div class="log-user-name">wulimin</div>
                    <div>werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        e</div>
                </div>
            </div>

            <div class="date">2017-05-25 12:20:23 </div>
            <div class="btn-box">
                <a href="/work/edit?id=2" class="log-alter">&nbsp;<i class="fa fa-pencil">&nbsp;</i></a>
            </div>
        </div>
    </div>

    <div class="split"><dt>昨天</dt>
        <div class="list-container">
            <div class="log-user">
                <div class="name-content">
                    <div class="log-user-name">wulimin</div>
                    <div>werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        werrwrwerweeeeeeeeeeweewrwwwwwwwwwrwrewrwerwreeeeeeee
                        e</div>
                </div>
            </div>

            <div class="date">2017-05-25 12:20:23 </div>
            <div class="btn-box">
                <a href="/work/edit?id=2" class="log-alter">&nbsp;<i class="fa fa-pencil">&nbsp;</i></a>
            </div>
        </div>
    </div>



</div>
<div class="user-login-info">
    <div class="user-info">
        <div class="username"><label>用户名：</label>wulimin</div>
        <div class="phone"><label>手机号：</label>1333333333</div>
        <div><label>最近登录：</label>2017-09-18 17:30</div>
        <div><label>登录次数：</label>2</div>
    </div>
</div>
@endsection

<script src="{{asset('static/editormd-log/js/jquery.min.js')}}"></script>
<script src="{{asset('static/editormd-log/js/editormd.min.js')}}"></script>
<script type="text/javascript">
    var testEditor;

    $(function() {
        testEditor = editormd("test-editormd", {
            width   : "95%",
            height  : 300,
            syncScrolling : "single",
            path    : "/static/editormd-log/lib/"
        });


    });
</script>

