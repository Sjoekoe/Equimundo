<?php

get('horses/{horse_slug}/pedigree', ['as' => 'pedigree.index', 'uses' => 'PedigreeController@index']);
get('horses/{horse_slug}/pedigree/create', ['as' => 'pedigree.create', 'uses' => 'PedigreeController@create', 'middleware' => 'auth']);
post('horses/{horse_slug}/pedigree/create', ['as' => 'pedigree.store', 'uses' => 'PedigreeController@store', 'middleware' => 'auth']);
get('pedigree/{pedigree}/delete', ['as' => 'pedigree.delete', 'uses' => 'PedigreeController@delete', 'middleware' => 'auth']);
