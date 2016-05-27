<?php

Route::get('/wiki', ['as' => 'wiki.index', 'uses' => 'WikiController@index']);
Route::get('/wiki/{topic}', ['as' => 'wiki.topic.show', 'uses' => 'WikiController@show']);
Route::get('/wiki/article/{article}', ['as' => 'wiki.article.show', 'uses' => 'WikiController@showArticle']);
