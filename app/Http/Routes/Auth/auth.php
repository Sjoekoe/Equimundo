<?php

Route::get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister'])->before('guest');
Route::post('register', ['as' => 'register', 'uses' => 'AuthController@postRegister'])->before('csrf');
Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin'])->before('guest');
Route::post('login', ['as' => 'login', 'uses' => 'AuthController@postLogin'])->before('csrf');
Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout'])->before('auth');
Route::get('activate', ['as' => 'activate', 'uses' => 'ActivationController@activate'])->before('guest');
