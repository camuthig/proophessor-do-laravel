<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'as' => 'page::home',
    function () {
        return view('proophessor_do/index', [
            'sidebar_right' => ''
        ]);
    }
]);

Route::get('/user-list', [
    'as' => 'page::user-list',
    'uses' => 'UserListController@get',
]);

Route::get('/user-registration', [
    'as' => 'page::user-registration-form',
    function () {
        return view('proophessor_do/user-registration-form');
    }
]);

Route::get('/user-todo-list/{userId}', [
    'as' => 'page::user-todo-list',
    'uses' => 'UserTodoListController@get'
]);

Route::get('/user-todo-form/{userId}/new-todo', [
    'as' => 'page::user-todo-form',
    'uses' => 'UserTodoFormController@get'
]);
