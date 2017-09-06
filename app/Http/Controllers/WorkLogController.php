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

    public function add()
    {
        return view('workLog.add', $this->data);
    }

    public function createOrUpdateData()
    {
        if ($this->isPost()) {
            $logType = intval($this->request->input('logType', 0));
            $attachmentUrl = $this->request->input('imgUrl','');
            $editorContent = $this->request->input('editor_content','');dd($editorContent);

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
                'attachmentUrl' => $attachmentUrl,
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
        $group = $this->request->input('group');
        $start_time = $this->request->input('start_time');
        $end_time = $this->request->input('end_time');
        $nickname = $this->request->input('nickname');

        $page = max(intval($this->request->input('page', 1)), 1);
        $select = workLog::select([
            'work_log.*',
            'member.account'
        ])->leftJoin('member', 'member.member_id', '=', 'work_log.member_id');
        if (isset($group) && $group >= 0) {
            $select->where('work_log.log_type', '=', $group);
        }
        if (!empty($start_time)) {
            $select->where('work_log.create_time', '>', $start_time . '00:00:00');
        }
        if (!empty($end_time)) {
            $select->where('work_log.create_time', '=', $end_time . '23:59:59');
        }
        if (!empty($nickname)) {
            $select->where('member.account', 'like', '%' . $nickname . '%');
        }
        $lists = $select->orderBy('work_log.create_time', 'DESC')->paginate(10, '*', 'page', $page);
        $this->data['logLists'] = $lists;
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


    public function delete($id = null)
    {
        $log_id = intval($id);

        if (empty($log_id) or $log_id <= 0) {
            return $this->jsonResult(40506);
        }
        $workLog = workLog::find($log_id);
        if (empty($workLog)) {
            abort(404);
        }
        $workLog->status = 1;
        if ($workLog->save() == false) {
            return $this->jsonResult(500);
        }
        return $this->jsonResult(0, ['state' => $workLog->state]);
    }


}