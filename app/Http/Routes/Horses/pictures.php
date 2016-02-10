<?php

get('horses/{horse_slug}/pictures', ['as' => 'horses.pictures.index', 'uses' => 'PicturesController@index', 'middleware' => 'auth']);
post('horses/{horse}/pictures/header-image', ['as' => 'horses.pictures.header', 'uses' => 'PicturesController@uploadHeaderImage', 'middleware' => 'auth']);
