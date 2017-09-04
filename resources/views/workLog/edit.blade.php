@extends('member')
@section('title')修改日志@endsection
@section('scripts')
    <script type="text/javascript">
        var value = '<?php echo $log->log_type;?>';
        $(document).ready(function () {
            if (value === '0') {
                $("#daily").show();
            } else {
                $("#daily").hide();
            }

            if (value === '1') {
                $("#week").show();
            } else {
                $("#week").hide();
            }

            if (value === '2') {
                $("#month").show();
            } else {
                $("#month").hide();
            }

            if (value === '3') {
                $("#year").show();
            } else {
                $("#year").hide();
            }
        });

        function showError($msg) {
            $("#error-message").addClass("error-message").removeClass("success-message").text($msg);
            return false;
        }

        function showSuccess($msg) {
            $("#error-message").addClass("success-message").removeClass("error-message").text($msg);
            return true;
        }

        $("#log-form").ajaxForm({
            beforeSubmit: function () {
                var $btn = $("button[type='submit']").button('loading');

                if (value === '0') {
                    var todayFinished = $.trim($("#todayFinished").val());
                    if (!todayFinished) {
                        $btn.button('reset');
                        return showError("今日完成工作不能为空");
                    }
                    var todayUnFinished = $.trim($("#todayUnFinished").val());
                    if (!todayUnFinished) {
                        $btn.button('reset');
                        return showError('未完成工作不能为空');
                    }
                }

                if (value === '1') {
                    var weekFinished = $.trim($("#weekFinished").val());
                    if (!weekFinished) {
                        $btn.button('reset');
                        return showError("本周完成工作不能为空");
                    }
                    var weekSummary = $.trim($("#weekSummary").val());
                    if (!weekSummary) {
                        $btn.button('reset');
                        return showError('本周工作总结不能为空');
                    }
                    var nextWeekPlan = $.trim($("#nextWeekPlan").val());
                    if (!nextWeekPlan) {
                        $btn.button('reset');
                        return showError('下周计划不能为空');
                    }
                }

                if (value === '2') {
                    var monthFinished = $.trim($("#monthFinished").val());
                    if (!monthFinished) {
                        $btn.button('reset');
                        return showError("本月工作内容不能为空");
                    }
                    var monthSummary = $.trim($("#monthSummary").val());
                    if (!monthSummary) {
                        $btn.button('reset');
                        return showError('本月工作总结不能为空');
                    }
                    var nextMonthPlan = $.trim($("#nextMonthPlan").val());
                    if (!nextMonthPlan) {
                        $btn.button('reset');
                        return showError('下月计划不能为空');
                    }
                }

                if (value === '3') {
                    var yearTarget = $.trim($("#yearTarget").val());
                    if (!yearTarget) {
                        $btn.button('reset');
                        return showError("今年目标不能为空");
                    }
                    var yearPlan = $.trim($("#yearPlan").val());
                    if (!yearPlan) {
                        $btn.button('reset');
                        return showError('今年关键计划不能为空');
                    }
                    var yearFinishSituation = $.trim($("#yearFinishSituation").val());
                    if (!yearFinishSituation) {
                        $btn.button('reset');
                        return showError('完成情况不能为空');
                    }
                }
            },
            success: function (res) {
                $("button[type='submit']").button('reset');
                if (res.errcode == 0) {
                    showSuccess("保存成功");
                    $("input[name='config_id']").val(res.data.id);
                } else {
                    showError(res.message);
                }
            }
        });
    </script>
@endsection
@section('content')
    <div class="member-box">
        <div class="box-head">
            <h4>修改日志</h4>
        </div>
        <div class="box-body">
            <form role="form" class="form-horizontal col-sm-5" method="post" action="{{route('workLog.createOrUpdateData')}}"
                  id="log-form">
                <input type="hidden" class="form-control" name="log_id" maxlength="20" placeholder=""
                       value="{{$log->id}}">
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
                        <input type="text" class="form-control" name="todayFinished" id="todayFinished" maxlength="20"
                               placeholder="" value="{{$log->today_finished}}">
                    </div>
                    <div class="form-group">
                        <label for="todayUnFinished">未完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayUnFinished" id="todayUnFinished"
                               maxlength="20" placeholder="" value="{{$log->today_unfinished}}">
                    </div>
                    <div class="form-group">
                        <label for="todayConcerted">需协调工作</label>
                        <input type="text" class="form-control" name="todayConcerted" id="todayConcerted" maxlength="20"
                               placeholder="" value="{{$log->concerted}}">
                    </div>
                </div>


                <div id="week" hidden>
                    <div class="form-group">
                        <label for="weekFinished">本周完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="weekFinished" id="weekFinished" maxlength="20"
                               placeholder="" value="{{$log->week_finished}}">
                    </div>
                    <div class="form-group">
                        <label for="weekSummary">本周工作总结</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="weekSummary" id="weekSummary" maxlength="20"
                               placeholder="" value="{{$log->week_summary}}">
                    </div>
                    <div class="form-group">
                        <label for="nextWeekPlan">下周工作计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="nextWeekPlan" id="nextWeekPlan" maxlength="20"
                               placeholder="" value="{{$log->next_week_plan}}">
                    </div>
                    <div class="form-group">
                        <label for="weekConcerted">需协调与帮助</label>
                        <input type="text" class="form-control" name="weekConcerted" id="weekConcerted" maxlength="20"
                               placeholder="" value="{{$log->concerted}}">
                    </div>
                </div>


                <div id="month" hidden>
                    <div class="form-group">
                        <label for="monthFinished">本月工作内容</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="monthFinished" id="monthFinished" maxlength="20"
                               placeholder="" value="{{$log->month_finished}}">
                    </div>
                    <div class="form-group">
                        <label for="monthSummary">本月工作总结</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="monthSummary" id="monthSummary" maxlength="20"
                               placeholder="" value="{{$log->month_summary}}">
                    </div>
                    <div class="form-group">
                        <label for="nextMonthPlan">下月工作计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="nextMonthPlan" id="nextMonthPlan" maxlength="20"
                               placeholder="" value="{{$log->next_month_plan}}">
                    </div>
                    <div class="form-group">
                        <label for="monthConcerted">需帮助与支持</label>
                        <input type="text" class="form-control" name="monthConcerted" id="monthConcerted" maxlength="20"
                               placeholder="" value="{{$log->concerted}}">
                    </div>
                </div>

                <div id="year" hidden>
                    <div class="form-group">
                        <label for="yearTarget">今年目标</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearTarget" id="yearTarget" maxlength="20"
                               placeholder="" value="{{$log->year_target}}">
                    </div>
                    <div class="form-group">
                        <label for="yearPlan">关键计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearPlan" id="yearPlan" maxlength="20"
                               placeholder="" value="{{$log->year_plan}}">
                    </div>
                    <div class="form-group">
                        <label for="yearFinishSituation">完成情况</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearFinishSituation" id="yearFinishSituation"
                               maxlength="20" placeholder="" value="{{$log->year_plan_finished_situation}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="remark">备注</label>
                    <textarea class="form-control" rows="3" title="描述" name="remark" id="remark"
                              maxlength="500">{{$log->remark}}</textarea>
                </div>
                <div class="form-group">
                    <label for="img">图片</label>
                    <span></span>
                    {{--<div id="filePicker" class="btn btn-success" >选择</div>--}}
                    {{--<button type="button" id="saveImage" class="btn btn-success"  data-loading-text="上传中...">上传图片</button>--}}
                    <label class="btn btn-success" for="saveImage" style="color:#fff">上传文件</label>
                    <input type="file" id="saveImage" name="saveImage" accept="image/*"
                           style="position:absolute;clip:rect(0 0 0 0);">
                </div>
                <div class="form-group">
                    <label for="img">附件</label>
                    <span></span>
                    {{--<div id="filePicker" class="btn btn-success" >选择</div>--}}
                    {{--<button type="button" id="saveImage" class="btn btn-success"  data-loading-text="上传中...">上传附件</button>--}}
                    <label class="btn btn-success" for="saveFile" style="color:#fff">上传文件</label>
                    <input type="file" id="saveFile" name="saveFile"
                           accept="text/plain,application/vnd.ms-excel,application/msword"
                           style="position:absolute;clip:rect(0 0 0 0);">
                </div>
                <div class="form-group">
                    <label for="sendToWho">发给谁</label><strong class="text-danger">*</strong>
                    <img src="{{asset('/static/images/plus.jpg')}}" style="width: 10%">&nbsp;添加人员<br>
                    <img src="{{asset('/static/images/plus.jpg')}}" style="width: 10%;margin-left:55px">&nbsp;添加组
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">提交</button>
                    <span id="error-message"></span>
                </div>
            </form>
        </div>
    </div>
@endsection