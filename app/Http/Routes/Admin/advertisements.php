<?php

Route::get('/admin/advertisements/companies', ['as' => 'admin.advertisements.companies.index', 'uses' => 'CompanyController@index']);
Route::get('/admin/advertisements/companies/create', ['as' => 'admin.advertisements.companies.create', 'uses' => 'CompanyController@create']);
Route::get('/admin/advertisements/companies/{advertising_company}', ['as' => 'admin.advertisements.companies.show', 'uses' => 'CompanyController@show']);

Route::get('/admin/advertisements', ['as' => 'admin.advertisements.index', 'uses' => 'AdvertisementController@index']);
Route::get('/admin/advertisements/create', ['as' => 'admin.advertisements.create', 'uses' => 'AdvertisementController@create']);
