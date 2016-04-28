<?php

Route::get('/admin/companies', ['as' => 'admin.companies.index', 'uses' => 'GroupController@index']);
