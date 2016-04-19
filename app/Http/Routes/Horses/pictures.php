<?php

Route::get('horses/{horse_slug}/pictures', ['as' => 'horses.pictures.index', 'uses' => 'PicturesController@index']);
Route::post('horses/{horse}/pictures/header-image', ['as' => 'horses.pictures.header', 'uses' => 'PicturesController@uploadHeaderImage', 'middleware' => 'auth']);
Route::get('pictures/{picture}/profile-picture', ['as' => 'horses.pictures.profile_picture', 'uses' => 'PicturesController@setProfilePicture', 'middleware' => 'auth']);
