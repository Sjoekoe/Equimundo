<?php

Route::get('/admin/wiki/topics', ['as' => 'admin.wiki.topics', 'uses' => 'Wiki\TopicController@index']);
