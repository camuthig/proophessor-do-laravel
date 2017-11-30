<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['command_name'])->group(function () {
    Route::post('/commands/register-user', [
        'as' => 'command::register-user',
        'uses' => 'ApiCommandController@postAction'
    ]);
});

