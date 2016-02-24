<?php

Route::get('edit-profile', ['as' => 'users.profiles.edit', 'uses' => 'ProfileController@edit', 'middleware' => 'auth']);
Route::post('edit-profile', ['as' => 'users.profiles.update', 'uses' => 'ProfileController@update', 'middleware' => 'auth']);
Route::get('users/delete', ['as' => 'users.delete', 'uses' => 'ProfileController@delete', 'middleware' => 'auth']);
Route::get('user/{user_slug}', ['as' => 'users.profiles.show', 'uses' => 'ProfileController@show']);
