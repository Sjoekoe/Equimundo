<?php

get('picture/{picture}', ['as' => 'file.picture', 'uses' => 'FileController@getImage']);
get('picture/{picture}/movie', ['as' => 'file.movie', 'uses' => 'FileController@getMovie']);
