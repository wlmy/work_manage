<?php

//写日志
Route::match(['get','post'],'/work/add',[
    'uses' => 'WorkLogController@add'
])->name('workLog.add');

Route::match(['get','post'],'/work/create',[
    'uses' => 'WorkLogController@create'
])->name('workLog.create');

Route::match(['get','post'],'/work/edit',[
    'uses' => 'WorkLogController@edit'
])->name('workLog.edit');
Route::match(['get','post'],'/work/detail',[
    'uses' => 'WorkLogController@detail'
])->name('workLog.detail');


//看日志
Route::match(['get','post'],'/work/index',[
    'uses' => 'WorkLogController@index'
])->name('workLog.index');