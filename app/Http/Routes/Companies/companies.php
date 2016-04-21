<?php

Route::get('/companies/create', ['as' => 'company.create', 'uses' => 'CompanyController@create']);
Route::get('/companies/{company}/edit', ['as' => 'company.edit', 'uses' => 'CompanyController@edit']);
Route::get('/companies/{company}/follow/{horse}', ['as' => 'companies.follow', 'uses' => 'CompanyController@follow']);
Route::get('/companies/{company}', ['as' => 'companies.show', 'uses' => 'CompanyController@show']);
