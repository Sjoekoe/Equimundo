<?php

get('settings', ['as' => 'settings.index', 'uses' => 'SettingController@index', 'middleware' => 'auth']);
put('settings', ['as' => 'settings.update', 'uses' => 'SettingController@update', 'middleware' => 'auth']);
get('invite-friends', ['as' => 'invite_friends', 'uses' => 'SettingController@invite', 'middleware' => 'auth']);
post('invite-friends', ['as' => 'invite_friends.store', 'uses' => 'SettingController@postInvite', 'middleware' => 'auth']);
