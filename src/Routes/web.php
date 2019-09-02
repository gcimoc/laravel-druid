<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('actions')->group(function () {
        Route::group(['namespace' => 'Genetsis\Druid\Controllers'], function () {
            Route::get('login', 'ActionsController@login');
            Route::get('register', 'ActionsController@register');
        });

        Route::get('logout', config('druid.callback_controller').'@logout')->name('actions.logout');
        Route::get('callback', config('druid.callback_controller').'@index');
    });
});
