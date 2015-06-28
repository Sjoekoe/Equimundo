<?php

Route::get('edit-profile', ['as' => 'users.profiles.edit', 'uses' => 'ProfileController@edit', 'middleware' => 'auth']);
Route::post('edit-profile', ['as' => 'users.profiles.update', 'uses' => 'ProfileController@update','middleware' => 'auth'])->before('csrf');
Route::get('user/{user}', ['as' => 'users.profiles.show', 'uses' => 'ProfileController@show']);
