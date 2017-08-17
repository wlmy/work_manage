<?php

//写日志
Route::match(['get','post'],'/write',[
    'uses' => 'WorkLogController@write'
])->name('workLog.write');

//
Route::match(['get','post'],'/see',[
    'uses' => 'WorkLogController@see'
])->name('workLog.see');