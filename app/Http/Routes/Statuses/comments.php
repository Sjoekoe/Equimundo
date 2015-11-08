<?php

post('statuses/{id}/comments', ['as' => 'comment.store', 'uses' => 'CommentController@store', 'middleware' => 'auth']);
