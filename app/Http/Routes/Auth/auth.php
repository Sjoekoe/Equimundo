<?php

get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister', 'middleware' => 'guest']);
post('register', ['as' => 'register', 'uses' => 'AuthController@postRegister']);
get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin', 'middleware' => 'guest']);
post('login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);
get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout', 'middleware' => 'auth']);
get('activate', ['as' => 'activate', 'uses' => 'ActivationController@activate', 'middleware' => 'guest']);
get('password/forgot', ['as' => 'password.forgot', 'uses' => 'PasswordController@getEmail', 'middleware' => 'guest']);
post('password/forgot', ['as' => 'password.post_forgot', 'uses' => 'PasswordController@postEmail', 'middleware' => 'guest']);
get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'PasswordController@getReset', 'middleware' => 'guest']);
post('password/reset/{token}', ['as' => 'password.post_reset', 'uses' => 'PasswordController@postReset', 'middleware' => 'guest']);
get('settings/password', ['as' => 'password.edit', 'uses' => 'PasswordController@edit', 'middleware' => 'auth']);
post('settings/password', ['as' => 'password.update', 'uses' => 'PasswordController@update', 'middleware' => 'auth']);
