<?php

Route::get('/tos', ['as' => 'terms_of_service', 'uses' => 'PagesController@terms']);
Route::get('/privacy', ['as' => 'privacy', 'uses' => 'PagesController@privacy']);
Route::get('/', ['as' => 'home', 'uses' => 'PagesController@home', 'middleware' => 'auth']);
