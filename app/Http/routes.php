<?php

Route::group(['namespace' => 'Auth'], function() {
    require __DIR__ . '/Routes/Auth/auth.php';
});

Route::group(['namespace' => 'Horses'], function() {
    require __DIR__ . '/Routes/Horses/horses.php';
});

Route::group(['namespace' => 'Pages'], function() {
    require __DIR__ . '/Routes/Pages/pages.php';
});

Route::group(['namespace' => 'Statuses'], function() {
    require __DIR__ . '/Routes/Statuses/statuses.php';
});

Route::group(['namespace' => 'Users'], function() {
    require __DIR__  .'/Routes/Users/profiles.php';
});