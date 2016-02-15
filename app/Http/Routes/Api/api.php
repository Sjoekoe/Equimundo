<?php

Route::get('/api/users/{user}/feed', ['as' => 'api.users.feed', 'uses' => 'UserController@feed']);
Route::get('/api/horses/{horse}', ['as' => 'api.horses.show', 'uses' => 'HorseController@show']);

Route::post('/api/statuses', ['as' => 'api.statuses.store', 'uses' => 'StatusController@store']);
Route::get('/api/statuses/{status}', ['as' => 'api.statuses.show', 'uses' => 'StatusController@show']);
Route::put('/api/statuses/{status}', ['as' => 'api.statuses.update', 'uses' => 'StatusController@update']);
Route::delete('/api/statuses/{status}', ['as' => 'api.statuses.delete', 'uses' => 'StatusController@delete']);

Route::get('/api/statuses/{status}/comments', ['as' => 'api.comments.index', 'uses' => 'CommentController@index']);
Route::post('/api/statuses/{status}/comments', ['as' => 'api.comments.store', 'uses' => 'CommentController@store']);
Route::get('/api/statuses/{status}/comments/{comment}', ['as' => 'api.comments.show', 'uses' => 'CommentController@show']);
Route::delete('/api/statuses/{status}/comments/{comment}', ['as' => 'api.comments.delete', 'uses' => 'CommentController@delete']);
