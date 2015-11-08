<?php

get('albums/{horseSlug}/create', ['as' => 'album.create', 'uses' => 'AlbumController@create']);
post('albums/{horseSlug}/create', ['as' => 'album.store', 'uses' => 'AlbumController@store']);
get('albums/{album}', ['as' => 'album.show', 'uses' => 'AlbumController@show']);
get('album/{album}/edit', ['as' => 'album.edit', 'uses' => 'AlbumController@edit', 'middleware' => 'auth']);
put('album/{album}/edit', ['as' => 'album.update', 'uses' => 'AlbumController@update', 'middleware' => 'auth']);
get('albums/{album}/delete', ['as' => 'album.delete', 'uses' => 'AlbumController@delete', 'middleware' => 'auth']);
