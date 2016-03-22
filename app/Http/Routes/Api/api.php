<?php

Route::get('/api/users/{user}', ['as' => 'api.users.show', 'uses' => 'UserController@show']);
Route::get('/api/users/{user}/horses', ['as' => 'api.users.horses.index', 'uses' => 'HorseController@index']);
Route::get('/api/users/{user}/feed', ['as' => 'api.users.feed', 'uses' => 'UserController@feed']);
Route::get('/api/users/{user}/notifications/reset-count', ['as' => 'api.users.notifications.reset_count', 'uses' => 'NotificationController@resetCount']);

Route::get('/api/horses/{horse}', ['as' => 'api.horses.show', 'uses' => 'HorseController@show']);

Route::get('/api/horses/{horse}/statuses', ['as' => 'api.horses.statuses.index', 'uses' => 'HorseStatusController@index']);

Route::post('/api/statuses', ['as' => 'api.statuses.store', 'uses' => 'StatusController@store']);
Route::get('/api/statuses/{status}', ['as' => 'api.statuses.show', 'uses' => 'StatusController@show']);
Route::put('/api/statuses/{status}', ['as' => 'api.statuses.update', 'uses' => 'StatusController@update']);
Route::delete('/api/statuses/{status}', ['as' => 'api.statuses.delete', 'uses' => 'StatusController@delete']);

Route::get('/api/statuses/{status}/comments', ['as' => 'api.comments.index', 'uses' => 'CommentController@index']);
Route::post('/api/statuses/{status}/comments', ['as' => 'api.comments.store', 'uses' => 'CommentController@store']);
Route::get('/api/statuses/{status}/comments/{comment}', ['as' => 'api.comments.show', 'uses' => 'CommentController@show']);
Route::put('/api/statuses/{status}/comments/{comment}', ['as' => 'api.comments.update', 'uses' => 'CommentController@update']);
Route::delete('/api/statuses/{status}/comments/{comment}', ['as' => 'api.comments.delete', 'uses' => 'CommentController@delete']);

Route::get('api/notifications', ['as' => 'api.notifications.index', 'uses' => 'NotificationController@index']);
Route::get('api/notifications/mark-as-read', ['as' => 'api.notifications.read', 'uses' => 'NotificationController@markRead']);
Route::get('api/notifications/{notification}', ['as' => 'api.notifications.show', 'uses' => 'NotificationController@show']);
Route::delete('api/notifications/{notification}', ['as' => 'api.notifications.delete', 'uses' => 'NotificationController@delete']);
