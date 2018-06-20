<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('actions')->group(function () {
        Route::group(['namespace' => 'Genetsis\Druid\Controllers'], function () {
            Route::get('logout', 'ActionsController@logout')->name('actions.logout');
            Route::get('login', 'ActionsController@login');
            Route::get('register', 'ActionsController@register');
        });

        Route::get('callback', config('druid_config.config.callback_controller').'@index');
    });
});