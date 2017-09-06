@extends('member')
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
        <div class="box-head">
            <h4>看日志</h4>
        </div>

        <form action="{{route("workLog.index")}}" id="form_search" method="post">
            <div class="table-bar">
                <div class="search-form fr cf">
                    <label class="type">日志类型：</label>
                    <div class="sleft">
                        <select name="group" class="search-input">
                            <option value="-1" @if(isset($_REQUEST['group']) && $_REQUEST['group'] == '-1') selected="selected" @endif>全部</option>
                            <option value="0" @if(isset($_REQUEST['group']) && $_REQUEST['group'] == '0') selected="selected" @endif>日报</option>
                            <option value="1" @if(isset($_REQUEST['group']) && $_REQUEST['group'] == '1') selected="selected" @endif>周报</option>
                            <option value="2" @if(isset($_REQUEST['group']) && $_REQUEST['group'] == '2') selected="selected" @endif>月报</option>
                            <option value="3" @if(isset($_REQUEST['group']) && $_REQUEST['group'] == '3') selected="selected" @endif>年计划</option>
                        </select>
                    </div>
                    <label class="type">选择日期：</label>
                    <div class="input-group date form_date col-md-3" data-date="" data-date-format="yyyy-mm-dd"
                         data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="float: left">
                        <input class="form-control search-input" size="16" type="text" value="@if(!empty($_REQUEST['start_time'])) {{$_REQUEST['start_time']}} @endif" readonly=""
                               name="start_time">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                    <label class="type">&nbsp;-&nbsp;</label>
                    <div class="input-group date form_date col-md-3" data-date="" data-date-format="yyyy-mm-dd"
                         data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" style="float: left">
                        <input class="form-control  search-input" size="16" type="text" value="@if(!empty($_REQUEST['end_time'])) {{$_REQUEST['end_time']}} @endif" readonly=""
                               name="end_time">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                    <label class="type" style="margin-left: 5px;">姓名：</label>
                    <div class="sleft">
                        <input type="text" placeholder="请输入用户姓名" value="@if(!empty($_REQUEST['nickname'])) {{$_REQUEST['nickname']}} @endif" class="search-input" name="nickname"
                               style="width: 120px">
                    </div>
                    <a url="{{route("workLog.index")}}" id="search" class="sch-btn "><i class="btn-search"></i></a>

                </div>
            </div>
        </form>


        <div class="box-body" style="padding-right: 0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td>序号</td>
                        <td>姓名</td>
                        <td>类型</td>
                        <td>创建时间</td>
                        <td>日志内容</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;?>
                    @foreach($lists as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td><p class="account">{{$item->account}}</p></td>
                            <td>
                                @if($item->log_type == 0)
                                    日报
                                @elseif($item->log_type == 1)
                                    周报
                                @elseif($item->log_type == 2)
                                    月报
                                @elseif($item->log_type == 3)
                                    年计划
                                @endif
                            </td>
                            <td>{{$item->create_time}}</td>
                            <td>
                                @if($item->log_type == 0)
                                    今日完成工作:{{$item->today_finished}}<br>
                                    未完成工作：{{$item->today_unfinished}}<br>
                                    需协调工作：{{$item->concerted}}<br>
                                @elseif($item->log_type == 1)
                                    本周完成工作：{{$item->week_finished}}<br>
                                    本周工作总结：{{$item->week_summary}}<br>
                                    下周工作计划：{{$item->next_week_plan}}<br>
                                    需协调与帮助：{{$item->concerted}}<br>
                                @elseif($item->log_type == 2)
                                    本月工作内容：{{$item->month_finished}}<br>
                                    本月工作总结：{{$item->month_summary}}<br>
                                    下月计划：{{$item->next_month_plan}}<br>
                                    需帮助与支持：{{$item->concerted}}<br>
                                @elseif($item->log_type == 3)
                                    今年目标：{{$item->year_target}}<br>
                                    关键计划：{{$item->year_plan}}<br>
                                    完成情况：{{$item->year_plan_finished_situation}}<br>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-item" data-id="{{$item->id}}"
                                        data-loading-text=" 删除中...">
                                    删除
                                </button>
                                <a href="{{route('workLog.edit',['id'=>$item->id])}}"
                                   class="btn btn-sm btn-default">编辑</a>
                                <a href="{{route('workLog.detail',['id'=>$item->id])}}" class="btn btn-sm btn-default">查看全文</a>
                            </td>
                        </tr>
                        <?php $i++;?>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection