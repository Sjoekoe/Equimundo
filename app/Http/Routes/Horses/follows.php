<?php

Route::get('horses/{horse_slug}/followers', ['as' => 'follows.index', 'uses' => 'FollowsController@index']);
Route::post('follows/{horse}', ['as' => 'follows.store', 'uses' => 'FollowsController@store', 'middleware' => 'auth']);
Route::delete('follows/{horse}', ['as' => 'follows.destroy', 'uses' => 'FollowsController@destroy', 'middleware' => 'auth']);
