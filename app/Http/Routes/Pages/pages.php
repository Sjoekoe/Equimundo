<?php

Route::get('/tos', ['as' => 'terms_of_service', 'uses' => 'PagesController@terms']);
Route::get('/privacy', ['as' => 'privacy', 'uses' => 'PagesController@privacy']);
Route::get('/sitemap', ['as' => 'sitemap', 'uses' => 'PagesController@sitemap']);
Route::get('/home', ['as' => 'marketing', 'uses' => 'PagesController@marketing']);
Route::get('/', ['as' => 'home', 'uses' => 'PagesController@home']);
Route::post('queue/receive', ['as' => 'queue.receive', 'uses' => 'PagesController@queue']);
