<?php

post('statuses/{status}/comments', ['as' => 'comment.store', 'uses' => 'CommentController@store', 'middleware' => 'auth']);
get('comments/{comment}/delete', ['as' => 'comment.delete', 'uses' => 'CommentController@delete', 'middleware' => 'auth']);
