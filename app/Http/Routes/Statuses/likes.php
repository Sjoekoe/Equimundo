<?php

Route::post('/statuses/{status}/like', ['as' => 'status.like', 'uses' => 'LikeController@like']);