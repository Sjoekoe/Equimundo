<?php

Route::get('settings/horses', ['as' => 'horses.settings.index', 'uses' => 'SettingsController@index', 'middleware' => 'auth']);
Route::get('settings/horses/{horse}/unlink', ['as' => 'horses.settings.unlink', 'uses' => 'SettingsController@unlink', 'middleware' => 'auth']);
Route::get('settings/horses/{horse}/delete', ['as' => 'horses.settings.delete', 'uses' => 'SettingsController@delete', 'middleware' => 'auth']);
