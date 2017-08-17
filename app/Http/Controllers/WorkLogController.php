<?php
/**
 * Created by PhpStorm.
 * User: wulimin
 * Date: 2017/08/17
 * Time: 9:00
 */

namespace SmartWiki\Http\Controllers;


use SmartWiki\Daily;

class WorkLogController extends Controller
{

    public function write()
    {


        return view('workLog.write', $this->data);

    }

    public function dailyCreate()
    {
        if ($this->isPost()) {
            $todayFinished = $this->request->input('todayFinished');
            $todayUnFinished = $this->request->input('todayUnFinished');
            $concerted = $this->request->input('concerted');
            $remark = $this->request->input('remark');
            $img = $this->request->input('img');
            $attachment = $this->request->input('attachment');
            $sendToWho = $this->request->input('sendToWho');

            $daily = new daily();
            if ($daily->save() == false) {
                return $this->jsonResult(500);
            }

            return $this->jsonResult(20002, $this->data);
        }
    }

    public function see()
    {
        return view('workLog.see', $this->data);
    }


}