<?php

get('horses/{horse_slug}/pictures', ['as' => 'horses.pictures.index', 'uses' => 'PicturesController@index', 'middleware' => 'auth']);
