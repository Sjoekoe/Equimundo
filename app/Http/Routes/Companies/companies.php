<?php

Route::get('/companies/{company}/follow/{horse}', ['as' => 'companies.follow', 'uses' => 'CompanyController@follow']);
Route::get('/companies/{company}', ['as' => 'companies.show', 'uses' => 'CompanyController@show']);
