<?php

get('edit-profile', ['as' => 'users.profiles.edit', 'uses' => 'ProfileController@edit', 'middleware' => 'auth']);
post('edit-profile', ['as' => 'users.profiles.update', 'uses' => 'ProfileController@update', 'middleware' => 'auth']);
get('user/{user}', ['as' => 'users.profiles.show', 'uses' => 'ProfileController@show']);
