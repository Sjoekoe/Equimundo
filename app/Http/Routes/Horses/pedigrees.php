<?php

Route::get('horses/{horseSlug}/pedigree', ['as' => 'pedigree.index', 'uses' => 'PedigreeController@index', 'middleware' => 'auth']);
Route::get('horses/{horseSlug}/pedigree/create', ['as' => 'pedigree.create', 'uses' => 'PedigreeController@create', 'middleware' => 'auth']);
Route::post('horses/{horseSlug}/pedigree/create', ['as' => 'pedigree.store', 'uses' => 'PedigreeController@store', 'middleware' => 'auth'])->before('csrf');