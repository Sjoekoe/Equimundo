<?php

Route::get('/admin/wiki/topics', ['as' => 'admin.wiki.topics', 'uses' => 'Wiki\TopicController@index']);
Route::get('/admin/wiki/topics/{topic}', ['as' => 'admin.wiki.topic', 'uses' => 'Wiki\TopicController@show']);
Route::get('/admin/wiki/topics/{topic}/articles/create', ['as' => 'admin.article.create', 'uses'=> 'Wiki\ArticleController@create']);
Route::post('/admin/wiki/topics/{topic}/articles/create', ['as' => 'admin.article.store', 'uses'=> 'Wiki\ArticleController@store']);
Route::get('/admin/wiki/topics/{topic}/articles/{article}/edit', ['as' => 'admin.articles.edit', 'uses' => 'Wiki\ArticleController@edit']);
Route::put('/admin/wiki/topics/{topic}/articles/{article}/edit', ['as' => 'admin.articles.update', 'uses' => 'Wiki\ArticleController@update']);
