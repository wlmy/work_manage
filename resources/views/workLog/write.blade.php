@extends('member')
@section('title')写日志@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $("input[type='radio']").click(function () {
            var radio_val = $("input[type='radio']:checked").val();
            if (radio_val === '0') {
                $("#daily").show();
            }else{
                $("#daily").hide();
            }

            if (radio_val === '1') {
                $("#week").show();
            }else{
                $("#week").hide();
            }

            if (radio_val === '2') {
                $("#month").show();
            }else{
                $("#month").hide();
            }

            if (radio_val === '3') {
                $("#year").show();
            }else{
                $("#year").hide();
            }
        });
    });
</script>
@endsection
@section('content')
    <div class="member-box">
        <div class="box-head">
            <h4>写日志</h4>
        </div>
        <div class="box-body">
            <form role="form" class="form-horizontal col-sm-5" method="post" action="{{route('workLog.create')}}" id="account-form">
                <div class="form-group">
                    <label for="log">日志类型：</label>
                    <label>
                        <input type="radio" name="workLogType" value="0" checked="">日报
                    </label>&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="workLogType" value="1">周报
                    </label>&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="workLogType" value="2">月报
                    </label>&nbsp;&nbsp;
                    <label>
                        <input type="radio" name="workLogType" value="3">年计划
                    </label>
                </div>
                <div id="daily">
                    <div class="form-group">
                        <label for="todayFinished">今日完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayFinished" id="todayFinished" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="todayUnFinished">未完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayUnFinished" id="todayUnFinished" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="todayConcerted">需协调工作</label>
                        <input type="text" class="form-control" name="todayConcerted" id="todayConcerted" maxlength="20" placeholder="" value="">
                    </div>
                </div>


                <div id="week" hidden>
                    <div class="form-group">
                        <label for="weekFinished">本周完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="weekFinished" id="weekFinished" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="weekSummary">本周工作总结</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="weekSummary" id="weekSummary" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="nextWeekPlan">下周工作计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="nextWeekPlan" id="nextWeekPlan" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="weekConcerted">需协调与帮助</label>
                        <input type="text" class="form-control" name="weekConcerted" id="weekConcerted" maxlength="20" placeholder="" value="">
                    </div>
                </div>


                <div id="month" hidden>
                    <div class="form-group">
                        <label for="monthFinished">本月工作内容</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="monthFinished" id="monthFinished" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="monthSummary">本月工作总结</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="monthSummary" id="monthSummary" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="nextMonthPlan">下月工作计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="nextMonthPlan" id="nextMonthPlan" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="monthConcerted">需帮助与支持</label>
                        <input type="text" class="form-control" name="monthConcerted" id="monthConcerted" maxlength="20" placeholder="" value="">
                    </div>
                </div>

                <div id="year" hidden>
                    <div class="form-group">
                        <label for="yearTarget">今年目标</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearTarget" id="yearTarget" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="yearPlan">关键计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearPlan" id="yearPlan" maxlength="20" placeholder="" value="">
                    </div>
                    <div class="form-group">
                        <label for="yearFinishSituation">完成情况</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="yearFinishSituation" id="yearFinishSituation" maxlength="20" placeholder="" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="remark">备注</label>
                    <textarea class="form-control" rows="3" title="描述" name="remark" id="remark" maxlength="500"></textarea>
                </div>
                <div class="form-group">
                    <label for="img">图片</label>
                    <span id="error-message"></span>
                    <div id="filePicker" class="btn btn-success" >选择</div>
                    <button type="button" id="saveImage" class="btn btn-success"  data-loading-text="上传中...">上传图片</button>
                </div>
                <div class="form-group">
                    <label for="img">附件</label>
                    <span id="error-message"></span>
                    <div id="filePicker" class="btn btn-success" >选择</div>
                    <button type="button" id="saveImage" class="btn btn-success"  data-loading-text="上传中...">上传附件</button>
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