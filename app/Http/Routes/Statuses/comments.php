<?php

Route::post('statuses/{status}/comments', ['as' => 'comment.store', 'uses' => 'CommentController@store', 'middleware' => 'auth']);
Route::get('comments/{comment}/edit', ['as' => 'comment.edit', 'uses' => 'CommentController@edit', 'middleware' => 'auth']);
Route::put('comments/{comment}edit', ['as' => 'comment.update', 'uses' => 'CommentController@update', 'middleware' => 'auth']);
Route::get('comments/{comment}/delete', ['as' => 'comment.delete', 'uses' => 'CommentController@delete', 'middleware' => 'auth']);
