<?php

namespace SmartWiki;

use Illuminate\Database\Eloquent\Model;


class workLog extends ModelBase
{
    protected $table = 'hf_work_log';
    protected $primaryKey = 'id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['id'];

    public $timestamps = false;


}
