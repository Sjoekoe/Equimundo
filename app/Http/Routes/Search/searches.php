<?php

get('search/results', ['as' => 'search.index', 'uses' => 'SearchController@index', 'middleware' => 'auth']);
post('search', ['as' => 'search', 'uses' => 'SearchController@search', 'middleware' => 'auth']);
