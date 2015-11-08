<?php

get('settings', ['as' => 'settings.index', 'uses' => 'SettingController@index', 'middleware' => 'auth']);
put('settings', ['as' => 'settings.update', 'uses' => 'SettingController@update', 'middleware' => 'auth']);
