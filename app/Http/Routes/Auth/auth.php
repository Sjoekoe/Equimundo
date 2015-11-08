<?php

get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister'])->before('guest');
post('register', ['as' => 'register', 'uses' => 'AuthController@postRegister'])->before('csrf');
get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin'])->before('guest');
post('login', ['as' => 'login', 'uses' => 'AuthController@postLogin'])->before('csrf');
get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout'])->before('auth');
get('activate', ['as' => 'activate', 'uses' => 'ActivationController@activate'])->before('guest');
