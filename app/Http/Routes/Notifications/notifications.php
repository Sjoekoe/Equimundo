<?php

get('notifications', ['as' => 'notifications.index', 'uses' => 'NotificationController@index', 'middleware' => 'auth']);
get('notifications/mark-read/{notification?}', ['as' => 'notifications.mark-read', 'uses' => 'NotificationController@markRead', 'middleware' => 'auth']);
