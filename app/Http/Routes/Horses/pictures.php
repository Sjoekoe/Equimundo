<?php

get('horses/{horseSlug}/pictures', ['as' => 'horses.pictures.index', 'uses' => 'PicturesController@index', 'middleware' => 'auth']);