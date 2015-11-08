<?php

get('horses/{horseSlug}/pedigree', ['as' => 'pedigree.index', 'uses' => 'PedigreeController@index', 'middleware' => 'auth']);
get('horses/{horseSlug}/pedigree/create', ['as' => 'pedigree.create', 'uses' => 'PedigreeController@create', 'middleware' => 'auth']);
post('horses/{horseSlug}/pedigree/create', ['as' => 'pedigree.store', 'uses' => 'PedigreeController@store', 'middleware' => 'auth'])->before('csrf');
get('pedigree/{pedigree}/edit', ['as' => 'pedigree.edit', 'uses' => 'PedigreeController@edit', 'middleware' => 'auth']);
put('pedigree/{pedigree}/edit', ['as' => 'pedigree.update', 'uses' => 'PedigreeController@update', 'middleware' => 'auth'])->before('csrf');
get('pedigree/{pedigree}/delete', ['as' => 'pedigree.delete', 'uses' => 'PedigreeController@delete', 'middleware' => 'auth']);
