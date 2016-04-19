<?php

Route::get('horses/{horse_slug}/pedigree', ['as' => 'pedigree.index', 'uses' => 'PedigreeController@index']);
Route::get('horses/{horse_slug}/pedigree/create', ['as' => 'pedigree.create', 'uses' => 'PedigreeController@create', 'middleware' => 'auth']);
Route::post('horses/{horse_slug}/pedigree/create', ['as' => 'pedigree.store', 'uses' => 'PedigreeController@store', 'middleware' => 'auth']);
Route::get('pedigree/{pedigree}/delete', ['as' => 'pedigree.delete', 'uses' => 'PedigreeController@delete', 'middleware' => 'auth']);
