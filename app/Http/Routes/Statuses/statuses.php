<?php

Route::post('/', ['as' => 'statuses.store', 'uses' => 'StatusController@store'])->before('csrf');
