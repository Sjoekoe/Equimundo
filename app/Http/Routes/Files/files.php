<?php

Route::get('picture/{picture}', ['as' => 'file.picture', 'uses' => 'FileController@getImage']);
Route::get('picture/{picture}/movie', ['as' => 'file.movie', 'uses' => 'FileController@getMovie']);
Route::get('picture/{picture}/advertisement', ['as' => 'file.advertisement', 'uses' => 'FileController@getAdvertisement']);

