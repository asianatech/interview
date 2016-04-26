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

Route::post('users/auth', [ 'uses' => 'AuthController@authenticate', 'as' => 'user.auth' ]);
Route::post('users/register', [ 'uses' => 'AuthController@register', 'as' => 'user.register' ]);


Route::group([ 'middleware' => ['jwt.auth']], function() {
    Route::put('users/{id}', [ 'uses' => 'UserController@update', 'as' => 'user.update' ]);
    Route::delete('users/{id}', [ 'uses' => 'UserController@destroy', 'as' => 'user.delete' ]);

    Route::post('blogs', [ 'uses' => 'BlogController@create', 'as' => 'blog.create' ]);
    Route::put('blogs/{id}', [ 'uses' => 'BlogController@update', 'as' => 'blog.update' ]);
    Route::delete('blogs/{id}', [ 'uses' => 'BlogController@destroy', 'as' => 'blog.delete' ]);
});