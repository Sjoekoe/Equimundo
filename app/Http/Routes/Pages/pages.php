<?php

Route::get('/tos', ['as' => 'terms_of_service', 'uses' => 'PagesController@terms']);
Route::get('/', ['as' => 'home', 'uses' => 'PagesController@home', 'middleware' => 'auth']);
