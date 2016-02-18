<?php

get('horses/{horse_slug}/pictures', ['as' => 'horses.pictures.index', 'uses' => 'PicturesController@index']);
post('horses/{horse}/pictures/header-image', ['as' => 'horses.pictures.header', 'uses' => 'PicturesController@uploadHeaderImage', 'middleware' => 'auth']);
get('pictures/{picture}/profile-picture', ['as' => 'horses.pictures.profile_picture', 'uses' => 'PicturesController@setProfilePicture', 'middleware' => 'auth']);
