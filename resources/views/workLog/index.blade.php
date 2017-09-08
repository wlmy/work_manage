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
        <div class="box-head">
            <h4>看日志</h4>
        </div>

        <form action="{{route("workLog.index")}}" id="form_search" method="post">
            <div class="search-form">
                <div class="first-row">
                    {{-- <div class="type">
                        <p> 模板筛选：</p>
                         <select name="group" class="search-input">
                             <option value="-1"
                                     @if(isset($_REQUEST['group']) && $_REQUEST['group'] == '-1') selected="selected" @endif>
                                 全部
                             </option>
                             <option value="0"
                                     @if(isset($_REQUEST['group']) && $_REQUEST['group'] == '0') selected="selected" @endif>
                                 日报
                             </option>
                             <option value="1"
                                     @if(isset($_REQUEST['group']) && $_REQUEST['group'] == '1') selected="selected" @endif>
                                 周报
                             </option>
                             <option value="2"
                                     @if(isset($_REQUEST['group']) && $_REQUEST['group'] == '2') selected="selected" @endif>
                                 月报
                             </option>
                             <option value="3"
                                     @if(isset($_REQUEST['group']) && $_REQUEST['group'] == '3') selected="selected" @endif>
                                 年计划
                             </option>
                         </select>

                     </div>--}}
                    <div class="nickname">
                        <h>姓名：&nbsp;&nbsp;&nbsp;</h>
                        <input type="text" placeholder="请输入用户姓名"
                               value="@if(!empty($_REQUEST['nickname'])) {{$_REQUEST['nickname']}} @endif"
                               class="search-input" name="nickname">
                        <a url="{{route("workLog.index")}}" id="search" class="sch-btn icon-box btn-search"> </a>
                    </div>

                </div>
                <div class="two-row">
                    <p  style="width: 90px">开始时间：</p>
                        <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd"
                             data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                            <input class="form-control search-input" size="16" type="text"
                                   value="@if(!empty($_REQUEST['start_time'])) {{$_REQUEST['start_time']}} @endif"
                                   readonly=""
                                   name="start_time">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                </div>
                <div class="two-row">
                    <p style="width: 90px">结束时间：</p>
                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd"
                         data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                        <input class="form-control search-input" size="16" type="text"
                               value="@if(!empty($_REQUEST['end_time'])) {{$_REQUEST['end_time']}} @endif"
                               readonly=""
                               name="end_time">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </form>
        @foreach($logLists as $item)
            <div class="list-container">
                <div class="log-user">
                    <div class="pic-box">
                        <p class="account">{{mb_substr($item->account,0,2)}}</p>
                    </div>
                    <div class="name-date">
                        <div>{{$item->account}}</div>
                        <div>{{$item->create_time}}</div>
                    </div>
                    @if(date('Y-m-d',strtotime($item->create_time)) == date('Y-m-d',time()))
                        <div class="btn-box">
                            <a href="/work/edit?id={{$item->id}}" class="log-alter">修改</a>
                        </div>
                    @endif
                </div>
                {{--  <div class="log-type">
                      @if($item->log_type == 0)
                          日报
                      @elseif($item->log_type == 1)
                          周报
                      @elseif($item->log_type == 2)
                          月报
                      @elseif($item->log_type == 3)
                          年计划
                      @endif
                  </div>--}}
                <div class="box">

                    @if($item->log_type == 0)
                        <div class="list">
                            <div class="list-name">今日完成工作:</div>
                            <div class="list-content">{{$item->today_finished}}</div>
                        </div>
                        <div class="list">
                            <div class="list-name">未完成工作:</div>
                            <div class="list-content">{{$item->today_unfinished}}</div>
                        </div>
                        <div class="list">
                            <div class="list-name">需协调工作:</div>
                            <div class="list-content">{{$item->concerted}}</div>
                        </div>
                    @elseif($item->log_type == 1)
                        <div class="list">
                            <div class="list-name">本周完成工作：</div>
                            <div class="list-content">{{$item->week_finished}}</div>
                        </div>
                        <div class="list">
                            <div class="list-name">本周工作总结:</div>
                            <div class="list-content">{{$item->week_summary}}</div>
                        </div>
                        <div class="list">
                            <div class="list-name">下周工作计划:</div>
                            <div class="list-content">{{$item->next_week_plan}}</div>
                        </div>
                        <div class="list">
                            <div class="list-name">需协调与帮助:</div>
                            <div class="list-content">{{$item->concerted}}</div>
                        </div>
                    @elseif($item->log_type == 2)
                        <div class="list">
                            <div class="list-name">本月工作内容：</div>
                            <div class="list-content">{{$item->month_finished}}</div>
                        </div>
                        <div class="list">
                            <div class="list-name">本月工作总结:</div>
                            <div class="list-content">{{$item->month_summary}}</div>
                        </div>
                        <div class="list">
                            <div class="list-name">下月计划:</div>
                            <div class="list-content">{{$item->next_month_plan}}</div>
                        </div>
                        <div class="list">
                            <div class="list-name">需帮助与支持:</div>
                            <div class="list-content">{{$item->concerted}}</div>
                        </div>
                    @elseif($item->log_type == 3)
                        <div class="list">
                            <div class="list-name">今年目标：</div>
                            <div class="list-content">{{$item->year_target}}</div>
                        </div>
                        <div class="list">
                            <div class="list-name">关键计划:</div>
                            <div class="list-content">{{$item->year_plan}}</div>
                        </div>
                        <div class="list">
                            <div class="list-name">完成情况:</div>
                            <div class="list-content">{{$item->year_plan_finished_situation}}</div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        <div>
            <nav>
                {{$logLists->appends(['nickname' => $logSearchParams['nickname'],'start_time'=> $logSearchParams['start_time'],'end_time'=>$logSearchParams['end_time']])->render()}}
            </nav>
        </div>

    </div>
@endsection