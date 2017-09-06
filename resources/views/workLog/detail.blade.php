@extends('member')
@section('title')查看日志@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var value = '<?php echo $log->log_type;?>';
            if(value === '0'){
                $("#daily").show();
            }else{
                $("#daily").hide();
            }

            if (value === '1') {
                $("#week").show();
            }else{
                $("#week").hide();
            }

            if (value === '2') {
                $("#month").show();
            }else{
                $("#month").hide();
            }

            if (value === '3') {
                $("#year").show();
            }else{
                $("#year").hide();
            }
        });
    </script>
@endsection
@section('content')
    <div class="member-box">
        <div class="box-head">
            <h4>查看全文</h4>
        </div>
        <div class="box-body">
            <form role="form" class="form-horizontal col-sm-5" method="post" action="" id="account-form">
                <input type="hidden" class="form-control" name="log_id"  maxlength="20" placeholder="" value="{{$log->id}}">
                <div class="form-group">
                    <label for="log">日志类型：</label>
                    <label style="color: #2aa198;font-weight:bold;">
                        @if($log->log_type == 0) 日报
                            @elseif($log->log_type == 1) 周报
                            @elseif($log->log_type == 2) 月报
                            @elseif($log->log_type == 3) 年计划
                        @endif
                    </label>&nbsp;&nbsp;

                </div>
                <div id="daily" hidden>
                    <div class="form-group">
                        <label for="todayFinished">今日完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayFinished" id="todayFinished" maxlength="20" placeholder="" value="{{$log->today_finished}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="todayUnFinished">未完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayUnFinished" id="todayUnFinished" maxlength="20" placeholder="" value="{{$log->today_unfinished}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="todayConcerted">需协调工作</label>
                        <input type="text" class="form-control" name="todayConcerted" id="todayConcerted" maxlength="20" placeholder="" value="{{$log->concerted}}" readonly>
                    </div>
                </div>


                <div id="week" hidden>
                    <div class="form-group">
                        <label for="weekFinished">本周完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="weekFinished" id="weekFinished" maxlength="20" placeholder="" value="{{$log->week_finished}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="weekSummary">本周工作总结</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="weekSummary" id="weekSummary" maxlength="20" placeholder="" value="{{$log->week_summary}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nextWeekPlan">下周工作计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="nextWeekPlan" id="nextWeekPlan" maxlength="20" placeholder="" value="{{$log->next_week_plan}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="weekConcerted">需协调与帮助</label>
                        <input type="text" class="form-control" name="weekConcerted" id="weekConcerted" maxlength="20" placeholder="" value="{{$log->concerted}}" readonly>
                    </div>
                </div>


                <div id="month" hidden>
                    <div class="form-group">
                        <label for="monthFinished">本月工作内容</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="monthFinished" id="monthFinished" maxlength="20" placeholder="" value="{{$log->month_finished}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="monthSummary">本月工作总结</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="monthSummary" id="monthSummary" maxlength="20" placeholder="" value="{{$log->month_summary}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nextMonthPlan">下月工作计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="nextMonthPlan" id="nextMonthPlan" maxlength="20" placeholder="" value="{{$log->next_month_plan}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="monthConcerted">需帮助与支持</label>
                        <input type="text" class="form-control" name="monthConcerted" id="monthConcerted" maxlength="20" placeholder="" value="{{$log->concerted}}" readonly>
                    </div>
                </div>

                <div id="year" hidden>
                    <div class="form-group">
                        <label for="yearTarget">今年目标</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearTarget" id="yearTarget" maxlength="20" placeholder="" value="{{$log->year_target}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="yearPlan">关键计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearPlan" id="yearPlan" maxlength="20" placeholder="" value="{{$log->year_plan}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="yearFinishSituation">完成情况</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearFinishSituation" id="yearFinishSituation" maxlength="20" placeholder="" value="{{$log->year_plan_finished_situation}}" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="remark">备注</label>
                    <textarea class="form-control" rows="3" title="描述" name="remark" id="remark" maxlength="500" readonly>{{$log->remark}}</textarea>
                </div>
                <div class="form-group">
                    <label for="img">图片</label>
                    <label>
                        <a href="javascript:;" data-toggle="modal" data-target="#upload-logo-panel">
                            <img src="{{$log->attachmentUrl}}" onerror="this.src='/static/images/middle.gif'" class="img-circle" alt="图片" style="max-width: 50px;max-height: 50px;" id="headimgurl">
                        </a>
                    </label>
                </div>
            </form>
        </div>
    </div>
@endsection