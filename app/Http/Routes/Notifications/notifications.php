<?php

get('notifications', ['as' => 'notifications.index', 'uses' => 'NotificationController@index', 'middleware' => 'auth']);
get('notifications/{notification}/show', ['as' => 'notifications.show', 'uses' => 'NotificationController@show', 'middleware', 'auth']);
get('notifications/{notification}/delete', ['as' => 'notification.delete', 'uses' => 'NotificationController@delete', 'middleware' => 'auth']);
get('notifications/mark-read', ['as' => 'notifications.mark-read', 'uses' => 'NotificationController@markRead', 'middleware' => 'auth']);
