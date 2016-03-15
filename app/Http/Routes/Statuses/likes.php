<?php

Route::post('api/statuses/{status}/like', ['as' => 'status.like', 'uses' => 'LikeController@like', 'middleware' => 'auth']);
Route::post('/comments/{comment}/like', ['as' => 'comment.like', 'uses' => 'LikeController@likeComment', 'middleware' => 'auth']);
