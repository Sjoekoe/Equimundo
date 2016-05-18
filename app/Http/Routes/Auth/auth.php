<?php

Route::get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister', 'middleware' => 'guest']);
Route::post('register', ['as' => 'register', 'uses' => 'AuthController@postRegister']);
Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin', 'middleware' => 'guest']);
Route::post('login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);
Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout', 'middleware' => 'auth']);
Route::get('activate', ['as' => 'activate', 'uses' => 'ActivationController@activate']);
Route::get('password/forgot', ['as' => 'password.forgot', 'uses' => 'PasswordController@getEmail', 'middleware' => 'guest']);
Route::post('password/forgot', ['as' => 'password.post_forgot', 'uses' => 'PasswordController@postEmail', 'middleware' => 'guest']);
Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'PasswordController@getReset', 'middleware' => 'guest']);
Route::post('password/reset/{token}', ['as' => 'password.post_reset', 'uses' => 'PasswordController@postReset', 'middleware' => 'guest']);
Route::get('settings/password', ['as' => 'password.edit', 'uses' => 'PasswordController@edit', 'middleware' => 'auth']);
Route::post('settings/password', ['as' => 'password.update', 'uses' => 'PasswordController@update', 'middleware' => 'auth']);

Route::group(['namespace' => 'Social\\'], function() {
    Route::get('/auth/facebook/redirect', ['as' => 'facebook.redirect', 'uses' => 'FaceBookController@redirect']);
    Route::get('/auth/facebook/callback', ['as' => 'facebook.callback', 'uses' => 'FaceBookController@callback']);
});
