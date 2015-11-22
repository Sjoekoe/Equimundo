<?php

get('horses/{horse_slug}/disciplines', ['as' => 'disciplines.index', 'uses' => 'DisciplineController@index', 'middleware' => 'auth']);
post('horses/{horse_slug}/disciplines', ['as' => 'disciplines.store', 'uses' => 'DisciplineController@store', 'middleware' => 'auth']);
