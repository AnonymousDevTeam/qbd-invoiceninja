<?php

Route::group(['middleware' => ['web', 'lookup:user', 'auth:user'], 'namespace' => 'Modules\QBD\Http\Controllers'], function()
{
    Route::resource('qbd', 'QBDController');
    Route::post('qbd/bulk', 'QBDController@bulk');
    Route::get('api/qbd', 'QBDController@datatable');
});

Route::group(['middleware' => 'api', 'namespace' => 'Modules\QBD\Http\ApiControllers', 'prefix' => 'api/v1'], function()
{
    Route::resource('qbd', 'QBDApiController');
});
