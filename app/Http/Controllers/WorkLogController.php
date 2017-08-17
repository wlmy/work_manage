<?php
/**
 * Created by PhpStorm.
 * User: wulimin
 * Date: 2017/08/17
 * Time: 9:00
 */

namespace SmartWiki\Http\Controllers;


use SmartWiki\workLog;

class WorkLogController extends Controller
{

    public function write()
    {
        return view('workLog.write', $this->data);
    }

    public function create()
    {
        if ($this->isPost()) {
            $logType = $this->request->input('logType');dd($logType);
            /*$img = $this->request->input('img');
            $attachment = $this->request->input('attachment');
            $sendToWho = $this->request->input('sendToWho');*/

            $dailyData = [
                'today_finished' => $this->request->input('todayFinished'),
                'today_unfinished' => $this->request->input('todayUnFinished'),
                'concerted' => $this->request->input('todayConcerted'),
                'remark' => $this->request->input('remark'),
            ];
            $weekData = [
                'week_finished' => $this->request->input('weekFinished'),
                'week_summary' => $this->request->input('weekSummary'),
                'next_week_plan' => $this->request->input('nextWeekPlan'),
                'concerted' => $this->request->input('weekConcerted'),
                'remark' => $this->request->input('remark'),
            ];
            $monthData = [
                'month_finished' => $this->request->input('monthFinished'),
                'month_summary' => $this->request->input('monthSummary'),
                'next_month_plan' => $this->request->input('nextMonthPlan'),
                'concerted' => $this->request->input('monthConcerted'),
                'remark' => $this->request->input('remark'),
            ];
            $yearData = [
                'year_target' => $this->request->input('yearTarget'),
                'year_plan' => $this->request->input('yearPlan'),
                'year_plan_finished_situation' => $this->request->input('yearFinishSituation'),
                'remark' => $this->request->input('remark'),
            ];
            $requestData = [
                'log_type' => empty($logType) ? 0 : $logType,
                /*'img' => $img,
                'attachment' => $attachment,
                'sendToWho' => $sendToWho,*/
                'create_time' => date('Y:m:d H:i:s', time()),
                'update_time' => date('Y:m:d H:i:s', time()),
            ];
            $differentTypeData = $logType == 0 ? $dailyData : ($logType == 1 ? $weekData : ($logType == 2 ? $monthData : ($logType == 3 ? $yearData : '')));
            $requestData = array_merge($requestData, $differentTypeData);
dd($logType,$requestData);
            $workLog = new workLog($requestData);
            if ($workLog->save() == false) {
                return $this->jsonResult(500);
            }

            return $this->jsonResult(20002, $this->data);
        }
    }

    public function edit()
    {

    }

    public function index()
    {


        return view('workLog.index', $this->data);
    }

    public function detail()
    {

    }


}