<?php
/**
 * Created by PhpStorm.
 * User: wulimin
 * Date: 2017/08/17
 * Time: 9:00
 */

namespace SmartWiki\Http\Controllers;


use Illuminate\Support\Facades\DB;
use SmartWiki\workLog;

class WorkLogController extends Controller
{

    public function add()
    {
        return view('workLog.add', $this->data);
    }

    public function create()
    {
        if ($this->isPost()) {
            $logType = intval($this->request->input('logType', 0));

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
                'member_id' => $this->data['member']['member_id'],
                'log_type' => empty($logType) ? 0 : $logType,
                /*'img' => $img,
                'attachment' => $attachment,
                'sendToWho' => $sendToWho,*/
                'create_time' => date('Y:m:d H:i:s', time()),
                'update_time' => date('Y:m:d H:i:s', time()),
            ];
            $differentTypeData = $logType == 0 ? $dailyData : ($logType == 1 ? $weekData : ($logType == 2 ? $monthData : ($logType == 3 ? $yearData : '')));
            $requestData = array_merge($requestData, $differentTypeData);

            $workLog = new workLog($requestData);
            $log_id = intval($this->request->input('log_id', 0));
            if ($log_id > 0) {
                $workLog = workLog::query()->find($log_id);
                if ($workLog->update($requestData) == false) {
                    return $this->jsonResult(500);
                }
            } else {
                if ($workLog->save() == false) {
                    return $this->jsonResult(500);
                }
            }
            return redirect('/work/index');
        }
    }

    public function edit()
    {
        $log_id = intval($this->request->input('id', 0));
        if ($log_id > 0) {
            $workLog = workLog::find($log_id);

            if (empty($workLog)) {
                abort(404);
            }
            $this->data['log'] = $workLog;
        } else {
            abort(404);
        }
        return view('workLog.edit', $this->data);
    }

    public function index()
    {
        $page = max(intval($this->request->input('page', 1)), 1);
        $log = workLog::select([
            'work_log.id',
            'work_log.log_type',
            'work_log.create_time',
            'work_log.update_time',
            'member.account'
        ])
            ->leftJoin('member', 'member.member_id', '=', 'work_log.member_id')
            ->orderBy('work_log.create_time', 'ASC')->paginate(20, '*', 'page', $page);
        $this->data['lists'] = $log;
        return view('workLog.index', $this->data);
    }

    public function detail()
    {
        $log_id = intval($this->request->input('id', 0));
        if ($log_id > 0) {
            $workLog = workLog::find($log_id);

            if (empty($workLog)) {
                abort(404);
            }
            $this->data['log'] = $workLog;
        } else {
            abort(404);
        }
        return view('workLog.detail', $this->data);
    }


}