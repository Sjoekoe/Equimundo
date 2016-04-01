<?php

Route::get('/admin/advertisements/companies', ['as' => 'admin.advertisements.companies.index', 'uses' => 'CompanyController@index']);
