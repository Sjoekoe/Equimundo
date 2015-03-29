<?php

Route::post('statuses/{id}/comments', ['as' => 'comment.store', 'uses' => 'CommentController@store']);