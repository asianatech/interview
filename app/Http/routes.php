<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middlewareGroups' => 'api'], function () {
    Route::post('user/create', 'UserController@create');
    Route::post('user/{id}/edit', 'UserController@edit');
    Route::post('user/{id}/delete', 'UserController@delete');

    Route::post('post/create', 'PostController@create');
    Route::post('post/{id}/edit', 'PostController@edit');
    Route::post('post/{id}/delete', 'PostController@delete');
});
