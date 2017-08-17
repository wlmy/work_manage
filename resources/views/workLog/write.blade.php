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
            <form role="form" class="form-horizontal col-sm-5" method="post" action="{{route('member.account')}}" id="account-form">
                <div class="form-group">
                    <label for="workLogType">日志类型：</label>
                    <label>
                        <input type="radio" name="workLogType" value="0" checked="">日报
                    </label>
                    <label>
                        <input type="radio" name="workLogType" value="1">周报
                    </label>
                    <label>
                        <input type="radio" name="workLogType" value="2">月报
                    </label>
                    <label>
                        <input type="radio" name="workLogType" value="3">年计划
                    </label>
                </div>
                <div id="daily">
                    <div class="form-group">
                        <label for="todayFinished">今日完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayFinished" id="todayFinished" maxlength="20" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="todayUnFinished">未完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayUnFinished" id="todayUnFinished" maxlength="20" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="concerted">需协调工作</label>
                        <input type="text" class="form-control" name="concerted" id="concerted" maxlength="20" placeholder="">
                    </div>
                </div>


                <div id="week" hidden>
                    <div class="form-group">
                        <label for="todayFinished">本周完成工作</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayFinished" id="todayFinished" maxlength="20" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="todayUnFinished">本周工作总结</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayUnFinished" id="todayUnFinished" maxlength="20" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="concerted">下周工作计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="concerted" id="concerted" maxlength="20" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="concerted">需协调与帮助</label>
                        <input type="text" class="form-control" name="concerted" id="concerted" maxlength="20" placeholder="">
                    </div>
                </div>


                <div id="month" hidden>
                    <div class="form-group">
                        <label for="todayFinished">本月工作内容</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayFinished" id="todayFinished" maxlength="20" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="todayUnFinished">本月工作总结</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayUnFinished" id="todayUnFinished" maxlength="20" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="concerted">下月工作计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="concerted" id="concerted" maxlength="20" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="concerted">需帮助与支持</label>
                        <input type="text" class="form-control" name="concerted" id="concerted" maxlength="20" placeholder="">
                    </div>
                </div>

                <div id="year" hidden>
                    <div class="form-group">
                        <label for="todayFinished">今年目标</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayFinished" id="todayFinished" maxlength="20" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="todayUnFinished">关键计划</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="todayUnFinished" id="todayUnFinished" maxlength="20" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="concerted">完成情况</label><strong class="text-danger">*</strong>
                        <input type="text" class="form-control" name="concerted" id="concerted" maxlength="20" placeholder="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="remark">备注</label>
                    <input type="text" class="form-control" id="remark" name="remark" maxlength="20" placeholder="">
                </div>
                <div class="form-group">
                    <label for="img">图片</label>
                    <input type="text" class="form-control" id="img" name="img" maxlength="20" placeholder="">
                </div>
                <div class="form-group">
                    <label for="img">附件</label>
                    <input type="text" class="form-control" id="img" name="img" maxlength="20" placeholder="">
                </div>
                <div class="form-group">
                    <label for="sendToWho">发给谁</label><strong class="text-danger">*</strong>
                    <input type="text" class="form-control" id="sendToWho" name="sendToWho" maxlength="20" placeholder="">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">提交</button>
                    <span id="error-message"></span>
                </div>
            </form>
        </div>
    </div>
@endsection