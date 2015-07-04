<?php

Route::get('settings', ['as' => 'settings.index', 'uses' => 'SettingController@index', 'middleware' => 'auth']);
Route::put('settings', ['as' => 'settings.update', 'uses' => 'SettingController@update', 'middleware' => 'auth'])->before('csrf');
