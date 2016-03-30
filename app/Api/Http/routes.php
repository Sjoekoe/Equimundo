<?php
use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', function(Router $api) {
    $api->group(['namespace' => 'EQM\\Api\\Http\\Controllers\\'], function (Router $api) {
        $api->get('/users/{user}', ['as' => 'api.users.show', 'uses' => 'UserController@show']);
        $api->get('/users/{user}/horses', ['as' => 'api.users.horses.index', 'uses' => 'HorseController@index']);
        $api->get('/users/{user}/feed', ['as' => 'api.users.feed', 'uses' => 'UserController@feed']);
        $api->get('/users/{user}/notifications/reset-count', ['as' => 'api.users.notifications.reset_count', 'uses' => 'NotificationController@resetCount']);

        $api->get('/horses/{horse}', ['as' => 'api.horses.show', 'uses' => 'HorseController@show']);

        $api->get('/horses/{horse}/statuses', ['as' => 'api.horses.statuses.index', 'uses' => 'HorseStatusController@index']);

        $api->post('/statuses', ['as' => 'api.statuses.store', 'uses' => 'StatusController@store']);
        $api->get('/statuses/{status}', ['as' => 'api.statuses.show', 'uses' => 'StatusController@show']);
        $api->put('/statuses/{status}', ['as' => 'api.statuses.update', 'uses' => 'StatusController@update']);
        $api->delete('/statuses/{status}', ['as' => 'api.statuses.delete', 'uses' => 'StatusController@delete']);
        $api->post('/statuses/{status}/like', ['as' => 'status.like', 'uses' => 'LikeController@like', 'middleware' => 'auth']);

        $api->get('/statuses/{status}/comments', ['as' => 'api.comments.index', 'uses' => 'CommentController@index']);
        $api->post('/statuses/{status}/comments', ['as' => 'api.comments.store', 'uses' => 'CommentController@store']);
        $api->get('/statuses/{status}/comments/{comment}', ['as' => 'api.comments.show', 'uses' => 'CommentController@show']);
        $api->put('/statuses/{status}/comments/{comment}', ['as' => 'api.comments.update', 'uses' => 'CommentController@update']);
        $api->delete('/statuses/{status}/comments/{comment}', ['as' => 'api.comments.delete', 'uses' => 'CommentController@delete']);

        $api->get('/notifications', ['as' => 'api.notifications.index', 'uses' => 'NotificationController@index']);
        $api->get('/notifications/mark-as-read', ['as' => 'api.notifications.read', 'uses' => 'NotificationController@markRead']);
        $api->get('/notifications/{notification}', ['as' => 'api.notifications.show', 'uses' => 'NotificationController@show']);
        $api->delete('/notifications/{notification}', ['as' => 'api.notifications.delete', 'uses' => 'NotificationController@delete']);
    });
});
