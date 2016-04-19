<?php

Route::get('horses/{horse_slug}/disciplines', ['as' => 'disciplines.index', 'uses' => 'DisciplineController@index', 'middleware' => 'auth']);
Route::post('horses/{horse_slug}/disciplines', ['as' => 'disciplines.store', 'uses' => 'DisciplineController@store', 'middleware' => 'auth']);
