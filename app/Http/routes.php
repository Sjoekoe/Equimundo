<?php

Route::group(['namespace' => 'Auth'], function() {
    require __DIR__ . '/Routes/Auth/auth.php';
});

Route::group(['namespace' => 'Horses'], function() {
    require __DIR__ . '/Routes/Horses/follows.php';
    require __DIR__ . '/Routes/Horses/horses.php';
    require __DIR__ . '/Routes/Horses/infos.php';
    require __DIR__ . '/Routes/Horses/palmares.php';
    require __DIR__ . '/Routes/Horses/pedigrees.php';
});

Route::group(['namespace' => 'Pages'], function() {
    require __DIR__ . '/Routes/Pages/pages.php';
});

Route::group(['namespace' => 'Statuses'], function() {
    require __DIR__ . '/Routes/Statuses/comments.php';
    require __DIR__ . '/Routes/Statuses/likes.php';
    require __DIR__ . '/Routes/Statuses/statuses.php';
});

Route::group(['namespace' => 'Users'], function() {
    require __DIR__  .'/Routes/Users/profiles.php';
});