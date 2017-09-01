@extends('member')
@section('title')看日志@endsection
@section('styles')
    <link href="{{asset('static/log/write.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('static/bootstrap/js/bootstrap-datetimepicker.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $(".delete-item").on("click",function () {
                var $btn = $(this).button('loading');
                var config_id = $(this).attr('data-id');
                var $then = $(this);
                $.post("{{route('member.setting.delete')}}/" + config_id).done(function (res) {
                    $then.parents('tr').remove().empty();
                    $btn.button('reset');
                }).fail(function () {
                    layer.msg('删除失败');
                    $btn.button('reset');
                });
            }) ;

            $(".form_datetime").datetimepicker({
                format: "yyyy-mm-dd  hh:ii",
                linkField: "mirror_field",
                linkFormat: "yyyy-mm-dd hh:ii"
            });
        });
    </script>
@endsection
@section('content')
    <div class="setting-box">
        <div class="box-head">
            <h4>看日志</h4>
            <a href="{{route('workLog.add')}}" class="btn btn-sm pull-right" style="background:#00a0e9;color:#fff;margin-top: 10px;">
                写日志
            </a>
        </div>

        <div class="table-bar">
            <div class="search-form fr cf">
                <label class="type">日志类型：</label>
                <div class="sleft">
                    <select name="group" style="border:none; padding:4px; margin:0;">
                        <option value="-1">全部</option>
                        <option value="0">日报</option>
                        <option value="1">周报</option>
                        <option value="2">月报</option>
                        <option value="3">年计划</option>
                    </select>
                </div>


                <label class="type">选择日期：</label>
                <div class="sleft">
                    <input class="form_datetime" size="20" type="text" value="" readonly >
                    <span class="add-on"><i class="icon-th"></i></span>
                    至
                    <input class="form_datetime" size="20" type="text" value="" readonly>
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>

                <label class="type">姓名：</label>
                <div class="sleft">
                    <input type="hidden" name="group_id" value="0">
                    <input type="text" placeholder="请输入用户姓名" value="" class="search-input" name="nickname">
                    <a url="" id="search" href="javascript:;" class="sch-btn"><i class="btn-search"></i></a> </div>
            </div>
        </div>
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
                    @foreach($lists as $item)
                            <tr>
                                <td>{{$item->id}}</td>
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
                                    <button type="button" class="btn btn-danger btn-sm delete-item" data-id="33"  data-loading-text="删除中...">
                                        删除
                                    </button>
                                    <a href="{{route('workLog.edit',['id'=>$item->id])}}" class="btn btn-sm btn-default">编辑</a>
                                    <a href="{{route('workLog.detail',['id'=>$item->id])}}" class="btn btn-sm btn-default">详情</a>
                                </td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection