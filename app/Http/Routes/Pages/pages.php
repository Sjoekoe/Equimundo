<?php

Route::get('/tos', ['as' => 'terms_of_service', 'uses' => 'PagesController@terms']);
Route::get('/privacy', ['as' => 'privacy', 'uses' => 'PagesController@privacy']);
Route::get('/competitions/jumping-antwerpen-2016', ['as' => 'jumping_antwerpen', 'uses' => 'PagesController@competition']);
Route::get('/', ['as' => 'home', 'uses' => 'PagesController@home', 'middleware' => 'auth']);
Route::post('queue/receive', ['as' => 'queue.receive', 'uses' => 'PagesController@queue']);
