@extends('header')
@section('title')看日志@endsection
@section('styles')
    <link href="{{asset('static/log/write.css')}}" rel="stylesheet">
    <link href="{{asset('static/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
    <link href="{{asset('static/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script type="text/javascript"
            src="{{asset('static/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('static/layer/layer.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $("#search").click(function () {
                var url = $(this).attr('url');
                var query = '';
                var i = 0;
                $('.search-input').each(function () {
                    var new_query = $(this).attr('name') + '=' + $(this).val().replace(/(^\s*)|(\s*$)/g, "");
                    if (i > 0) {
                        query += '&' + new_query;
                    } else {
                        query = new_query;
                    }
                    i++;
                });

                if (url.indexOf('?') > 0) {
                    url += '&' + query;
                } else {
                    url += '?' + query;
                }
                window.location.href = url;
            });

            $(".delete-item").on("click", function () {
                var config_id = $(this).attr('data-id');
                layer.confirm('确定删除?', function () {
                    $.post("{{route('workLog.delete')}}/" + config_id).success(function () {
                        layer.msg('删除成功！');
                    }).fail(function () {
                        layer.msg('删除失败！');
                    });
                });
            });

            $('.form_date').datetimepicker({
                format: "yyyy-mm-dd",
                language: 'fr',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                minView: 2,
                forceParse: 0
            });
        });
    </script>
@endsection
@section('content')
    <div class="setting-box">
        <form action="{{route("workLog.other")}}" id="form_search" method="post">
            <div class="search-form" style="margin-left: -10px">
                <div class="search-list">
                    <p style="width: 86px">开始时间：</p>
                    <div class="input-group date form_date col-md-7" data-date="" data-date-format="yyyy-mm-dd"
                         data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                        <input class="form-control search-input" size="16" type="text"
                               value="@if(!empty($_REQUEST['start_time'])) {{$_REQUEST['start_time']}} @endif"
                               readonly=""
                               name="start_time">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
                <div class="search-list">
                    <p style="width: 86px">结束时间：</p>
                    <div class="input-group date form_date col-md-7" data-date="" data-date-format="yyyy-mm-dd"
                         data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                        <input class="form-control search-input" size="16" type="text"
                               value="@if(!empty($_REQUEST['end_time'])) {{$_REQUEST['end_time']}} @endif"
                               readonly=""
                               name="end_time">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>

                <div class="report-user-name search-list" style="position: absolute;float: left">
                    <p style="width: 58px">姓名：</p>
                    <div class="search-user-name">
                        <input type="text" class="form-control" name="user_name" placeholder="请输入用户名搜索" value="">
                    </div>
                    <div class="search-btn-box">
                        <button class="btn btn-success" style="margin-left:3px">搜索</button>
                    </div>
                </div>
            </div>
        </form>

        <?php foreach($logLists as $key => $val){?>
        <div class="split">
            <dt1>&nbsp;</dt1>
            <div class="list-container">
                <div class="log-user">
                    <div class="name-content">
                        <div class="log-user-name">{{$val['account']}}</div>
                        <div><?php echo markdown_converter($val['editorContent'])?></div>
                    </div>
                </div>

                <div class="date">{{$val['create_time']}}</div>
                <div class="btn-box">
                    <?php if($val['account'] == $member->account && substr($val['create_time'], 0 ,10) == date('Y-m-d')){?><a href="/work/edit?id={{$val['id']}}" class="log-alter">&nbsp;<i class="fa fa-pencil">&nbsp;</i></a> <?php }?>
                </div>
            </div>
        </div>
        <?php }?>

        <div style="float: right">
            <nav>
                {{$logLists->appends(['nickname' => $logSearchParams['nickname'],'start_time'=> $logSearchParams['start_time'],'end_time'=>$logSearchParams['end_time']])->render()}}
            </nav>
        </div>

    </div>
@endsection