<?php

get('horses/{horseSlug}/info', ['as' => 'horse.info', 'uses' => 'InfoController@index', 'middleware' => 'auth']);
