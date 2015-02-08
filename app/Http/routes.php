<?php

Route::group(['namespace' => 'Auth'], function() {
    require __DIR__ . '/Routes/Auth/auth.php';
});

Route::get('/', ['as' => 'home', 'uses' => 'PagesController@home']);
