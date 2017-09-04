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

            $("#search").click(function () {
                var url = $(this).attr('url');
                var query = '';
                var i = 0;
                $('.search-val').each(function () {
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
                $.get(url);
            });

            //回车自动提交
           /* $('.search-form').find('input').keyup(function (event) {
                if (event.keyCode === 13) {
                    $("#search").click();
                }
            });*/
        });
    </script>
@endsection
@section('content')
    <div class="setting-box">
        <div class="box-head">
            <h4>看日志</h4>
            <a href="{{route('workLog.add')}}" class="btn btn-sm pull-right"
               style="background:#00a0e9;color:#fff;margin-top: 10px;">
                写日志
            </a>
        </div>

        <form action="{{route("workLog.index")}}" id="form_search" method="post">
            <div class="table-bar">
                <div class="search-form fr cf">
                    <label class="type">日志类型：</label>
                    <div class="sleft">
                        <select name="group" style="border:none; padding:4px; margin:0;" class="search-val">
                            <option value="-1">全部</option>
                            <option value="0">日报</option>
                            <option value="1">周报</option>
                            <option value="2">月报</option>
                            <option value="3">年计划</option>
                        </select>
                    </div>
                    <label class="type">选择日期：</label>
                    <div class="input-group date form_date col-md-3" data-date="" data-date-format="yyyy-mm-dd"
                         data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                        <input class="form-control search-val" size="16" type="text" value="" readonly=""
                               name="start_time">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                    <div class="input-group date form_date col-md-3" data-date="" data-date-format="yyyy-mm-dd"
                         data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                        <input class="form-control  search-val" size="16" type="text" value="" readonly=""
                               name="end_time">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>

                    <label class="type">姓名：</label>
                    <div class="sleft">
                        <input type="hidden" name="group_id" value="0">
                        <input type="text" placeholder="请输入用户姓名" value="" class="search-val" name="nickname">
                    </div>
                    <a url="{{route("workLog.index")}}" id="search" href="" class="sch-btn"><i
                                class="btn-search"></i></a>
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
                        <td>日志名称</td>
                        <td>创建时间</td>
                        <td>更新时间</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;?>
                    @foreach($lists as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$item->account}}</td>
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
                            <td>{{$item->update_time}}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-item" data-id="{{$item->id}}"
                                        data-loading-text=" 删除中...">
                                    删除
                                </button>
                                <a href="{{route('workLog.edit',['id'=>$item->id])}}"
                                   class="btn btn-sm btn-default">编辑</a>
                                <a href="{{route('workLog.detail',['id'=>$item->id])}}" class="btn btn-sm btn-default">详情</a>
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