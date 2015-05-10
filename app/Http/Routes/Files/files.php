<?php

Route::get('picture/{horseId}/{path}', ['as' => 'file.picture', 'uses' => 'FileController@getImage']);