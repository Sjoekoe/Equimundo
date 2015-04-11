<?php

Route::post('follows', ['as' => 'follows.store', 'uses' => 'FollowsController@store', 'middleware' => 'auth'])->before('csrf');
Route::delete('follows/{id}', ['as' => 'follows.destroy', 'uses' => 'FollowsController@destroy', 'middleware' => 'auth']);