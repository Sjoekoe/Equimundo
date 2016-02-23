<?php

get('horses/{horse_slug}/followers', ['as' => 'follows.index', 'uses' => 'FollowsController@index']);
post('follows/{horse}', ['as' => 'follows.store', 'uses' => 'FollowsController@store', 'middleware' => 'auth']);
delete('follows/{horse}', ['as' => 'follows.destroy', 'uses' => 'FollowsController@destroy', 'middleware' => 'auth']);
