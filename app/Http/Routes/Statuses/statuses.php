<?php

Route::post('/', ['as' => 'statuses.store', 'uses' => 'StatusController@store', 'middleware' => 'auth'])->before('csrf');
