<?php

namespace SmartWiki;

use Illuminate\Database\Eloquent\Model;


class Daily extends ModelBase
{
    protected $table = 'wk_daily';
    protected $primaryKey = 'id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['id'];

    public $timestamps = false;


}
