<?php

Route::post('/', ['as' => 'statuses.store', 'uses' => 'StatusController@store', 'middleware' => 'auth'])->before('csrf');
Route::get('status/{status}/show', ['as' => 'statuses.show', 'uses' => 'StatusController@show']);
Route::get('status/{status}/edit', ['as' => 'statuses.edit', 'uses' => 'StatusController@edit', 'middleware' => 'auth']);
Route::put('status/{status}/edit', ['as' => 'statuses.update', 'uses' => 'StatusController@update', 'middleware' => 'auth'])->before('csrf');
Route::get('status/{status}/delete', ['as' => 'statuses.delete', 'uses' => 'StatusController@delete', 'middleware' => 'auth']);
