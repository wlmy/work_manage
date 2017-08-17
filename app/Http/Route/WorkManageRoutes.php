<?php

//写日志
Route::match(['get','post'],'/work/write',[
    'uses' => 'WorkLogController@write'
])->name('workLog.write');

Route::match(['get','post'],'/work/create',[
    'uses' => 'WorkLogController@create'
])->name('workLog.create');

Route::match(['get','post'],'/work/edit',[
    'uses' => 'WorkLogController@v'
])->name('workLog.edit');


//看日志
Route::match(['get','post'],'/work/index',[
    'uses' => 'WorkLogController@index'
])->name('workLog.index');