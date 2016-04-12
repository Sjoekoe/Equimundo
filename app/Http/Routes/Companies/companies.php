<?php

Route::get('/companies/{company}', ['as' => 'companies.show', 'uses' => 'CompanyController@show']);
