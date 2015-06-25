<?php

Route::get('search/results', ['as' => 'search.index', 'uses' => 'SearchController@index', 'middleware' => 'auth']);
Route::post('search', ['as' => 'search', 'uses' => 'SearchController@search', 'middleware' => 'auth']);
