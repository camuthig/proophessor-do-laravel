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

    Route::post('/commands/add-deadline-to-todo', [
        'as' => 'command::add-deadline-to-todo',
        'uses' => 'ApiCommandController@postAction'
    ]);

    Route::post('/commands/add-reminder-to-todo', [
        'as' => 'command::add-reminder-to-todo',
        'uses' => 'ApiCommandController@postAction'
    ]);

    Route::post('/commands/mark-todo-as-done', [
        'as' => 'command::mark-todo-as-done',
        'uses' => 'ApiCommandController@postAction'
    ]);

    Route::post('/commands/mark-todo-as-expired', [
        'as' => 'command::mark-todo-as-expired',
        'uses' => 'ApiCommandController@postAction'
    ]);

    Route::post('/commands/reopen-todo', [
        'as' => 'command::reopen-todo',
        'uses' => 'ApiCommandController@postAction'
    ]);

    Route::post('/commands/post-todo', [
        'as' => 'command::post-todo',
        'uses' => 'ApiCommandController@postAction'
    ]);
});
