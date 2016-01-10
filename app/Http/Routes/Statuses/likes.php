<?php

post('/statuses/{status}/like', ['as' => 'status.like', 'uses' => 'LikeController@like', 'middleware' => 'auth']);
post('/comments/{comment}/like', ['as' => 'comment.like', 'uses' => 'Likecontroller@likeComment', 'middleware' => 'auth']);
