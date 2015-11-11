<?php

post('albums/{album}/add-picture', ['as' => 'album.picture.store', 'uses' => 'PictureController@store', 'middleware' => 'auth']);
get('albums/{album}/remove-picture/{picture}', ['as' => 'album.picture.delete', 'uses' => 'PictureController@delete', 'middleware' => 'auth']);
