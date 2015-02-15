<?php

Route::get('edit-profile', ['as' => 'users.profiles.edit', 'uses' => 'ProfileController@edit'])->before('auth');
Route::post('edit-profile', ['as' => 'users.profiles.update', 'uses' => 'ProfileController@update'])->before('csrf');