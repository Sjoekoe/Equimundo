<?php

Route::get('admin/horses', ['as' => 'admin.horses.index', 'uses' => 'HorseController@index']);
