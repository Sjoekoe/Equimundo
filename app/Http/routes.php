<?php

Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function() {
    require __DIR__ . '/Routes/Admin/dashboards.php';
    require __DIR__ . '/Routes/Admin/users.php';
});

Route::group(['namespace' => 'Albums'], function() {
    require __DIR__ . '/Routes/Albums/albums.php';
    require __DIR__ . '/Routes/Albums/pictures.php';
});

Route::group(['namespace' => 'Auth'], function() {
    require __DIR__ . '/Routes/Auth/auth.php';
});

Route::group(['namespace' => 'Conversations'], function() {
    require __DIR__ . '/Routes/Conversations/conversations.php';
    require __DIR__ . '/Routes/Conversations/messages.php';
});

Route::group(['namespace' => 'Files'], function() {
    require __DIR__ . '/Routes/Files/files.php';
});

Route::group(['namespace' => 'Horses'], function() {
    require __DIR__ . '/Routes/Horses/disciplines.php';
    require __DIR__ . '/Routes/Horses/follows.php';
    require __DIR__ . '/Routes/Horses/horses.php';
    require __DIR__ . '/Routes/Horses/infos.php';
    require __DIR__ . '/Routes/Horses/palmares.php';
    require __DIR__ . '/Routes/Horses/pedigrees.php';
    require __DIR__ . '/Routes/Horses/pictures.php';
});

Route::group(['namespace' => 'Notifications'], function() {
    require __DIR__ . '/Routes/Notifications/notifications.php';
});

Route::group(['namespace' => 'Pages'], function() {
    require __DIR__ . '/Routes/Pages/pages.php';
});

Route::group(['namespace' => 'Search'], function() {
    require __DIR__ . '/Routes/Search/searches.php';
});

Route::group(['namespace' => 'Statuses'], function() {
    require __DIR__ . '/Routes/Statuses/comments.php';
    require __DIR__ . '/Routes/Statuses/likes.php';
    require __DIR__ . '/Routes/Statuses/statuses.php';
});

Route::group(['namespace' => 'Users'], function() {
    require __DIR__  .'/Routes/Users/profiles.php';
    require __DIR__ . '/Routes/Users/settings.php';
});
