<?php

Route::get('albums/{horseSlug}/create', ['as' => 'album.create', 'uses' => 'AlbumController@create']);
Route::post('albums/{horseSlug}/create', ['as' => 'album.store', 'uses' => 'AlbumController@store']);
Route::get('albums/{album}', ['as' => 'album.show', 'uses' => 'AlbumController@show']);
Route::get('album/{album}/edit', ['as' => 'album.edit', 'uses' => 'AlbumController@edit', 'middleware' => 'auth']);
Route::put('album/{album}/edit', ['as' => 'album.update', 'uses' => 'AlbumController@update', 'middleware' => 'auth']);
Route::get('albums/{album}/delete', ['as' => 'album.delete', 'uses' => 'AlbumController@delete', 'middleware' => 'auth']);
