<?php

//写日志
Route::match(['get','post'],'/work/add',[
    'uses' => 'WorkLogController@add'
])->name('workLog.add');

Route::match(['get','post'],'/work/edit',[
    'uses' => 'WorkLogController@edit'
])->name('workLog.edit');
Route::match(['get','post'],'/work/delete/{id?}',[
    'uses' => 'WorkLogController@delete'
])->name('workLog.delete');
Route::match(['get','post'],'/work/detail',[
    'uses' => 'WorkLogController@detail'
])->name('workLog.detail');

Route::match(['get','post'],'/work/createOrUpdateData',[
    'uses' => 'WorkLogController@createOrUpdateData'
])->name('workLog.createOrUpdateData');


//看日志
Route::match(['get','post'],'/work/index',[
    'uses' => 'WorkLogController@index'
])->name('workLog.index');