<?php

get('horses/{horse_slug}/pedigree', ['as' => 'pedigree.index', 'uses' => 'PedigreeController@index', 'middleware' => 'auth']);
get('horses/{horse_slug}/pedigree/create', ['as' => 'pedigree.create', 'uses' => 'PedigreeController@create', 'middleware' => 'auth']);
post('horses/{horse_slug}/pedigree/create', ['as' => 'pedigree.store', 'uses' => 'PedigreeController@store', 'middleware' => 'auth'])->before('csrf');
get('pedigree/{horse_slug}/edit', ['as' => 'pedigree.edit', 'uses' => 'PedigreeController@edit', 'middleware' => 'auth']);
put('pedigree/{horse_slug}/edit', ['as' => 'pedigree.update', 'uses' => 'PedigreeController@update', 'middleware' => 'auth'])->before('csrf');
get('pedigree/{pedigree}/delete', ['as' => 'pedigree.delete', 'uses' => 'PedigreeController@delete', 'middleware' => 'auth']);
