<?php

Route::get('/admin/searches', ['as' => 'admin.searches.index', 'uses' => 'SearchController@index']);
