<?php

Route::group(['namespace' => 'Auth'], function() {
    require __DIR__ . '/Routes/Auth/auth.php';
});

Route::group(['namespace' => 'Pages'], function() {
    require __DIR__ . '/Routes/Pages/pages.php';
});
