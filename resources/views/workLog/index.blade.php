@extends('member')
@section('title')看日志@endsection
@section('scripts')
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
        });
    </script>
@endsection
@section('content')
    <div class="setting-box">
        <div class="box-head">
            <h4>看日志</h4>
            <a href="{{route('workLog.write')}}" class="btn btn-success btn-sm pull-right" style="margin-top: 10px;">
                写日志
            </a>
        </div>

        <div class="box-body">
            <div>
                <span>日志类型：</span>
                <div><span style="width: 85px;">全部</span>
                    <ul style="position: absolute; top: 26px; display: none; z-index: 9999; left: -1px;">
                        <li data-value="0" class="selected">全部</li>
                        <li data-value="4">月计划</li>
                        <li data-value="5">周计划</li>
                    </ul>
                </div>
                <span>统计时间：</span>
                <div>
				<input readonly="" placeholder="开始时间">
                </div>
                <div>
				<input readonly="" placeholder="结束时间">
                </div>
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

                        <tr>
                            <td colspan="6"></td>
                        </tr>


                            <tr>
                                <td>e</td>
                                <td>e</td>
                                <td>w</td>
                                <td>e</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-item" data-id="33"  data-loading-text="删除中...">
                                        删除
                                    </button>
                                    <a href="" class="btn btn-sm btn-default">编辑</a>
                                    <a href="" class="btn btn-sm btn-default">详情</a>
                                </td>
                            </tr>



                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection