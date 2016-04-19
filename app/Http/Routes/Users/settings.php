<?php

Route::get('settings', ['as' => 'settings.index', 'uses' => 'SettingController@index', 'middleware' => 'auth']);
Route::put('settings', ['as' => 'settings.update', 'uses' => 'SettingController@update', 'middleware' => 'auth']);
Route::get('invite-friends', ['as' => 'invite_friends', 'uses' => 'SettingController@invite', 'middleware' => 'auth']);
Route::post('invite-friends', ['as' => 'invite_friends.store', 'uses' => 'SettingController@postInvite', 'middleware' => 'auth']);
