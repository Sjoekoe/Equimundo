<?php

Route::get('admin/dashboard', ['as' => 'admin.dashboard', 'uses' => 'DashboardController@index']);
