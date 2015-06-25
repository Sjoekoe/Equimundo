<?php

Route::get('admin/users', ['as' => 'admin.users', 'uses' => 'UserController@index']);
