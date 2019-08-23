<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('api/v1')->group(function () {
 //       Route::middleware('user.connected')->get('optin', 'App\Http\Controllers@optin');
    });
});
