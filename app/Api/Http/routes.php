<?php
use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', function(Router $api) {
    $api->group(['namespace' => 'EQM\\Api\\Http\\Controllers\\'], function (Router $api) {
        $api->post('/addresses', ['as' => 'api.addresses.create', 'uses' => 'AddressController@create']);

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

        $api->group(['namespace' => 'Admin\\', 'prefix' => 'admin'], function(Router $api) {
            $api->group(['prefix' => 'advertisements'], function(Router $api) {

                $api->group(['prefix' => 'contacts'], function(Router $api) {
                    $api->get('/', ['as' => 'api.admin.advertisements.contacts.index', 'uses' => 'ContactController@index']);
                    $api->post('/', ['as' => 'api.admin.advertisements.contacts.store', 'uses' => 'ContactController@store']);
                    $api->get('/{advertising_contact}', ['as' => 'api.admin.advertisements.contacts.show', 'uses' => 'ContactController@show']);
                    $api->put('/{advertising_contact}', ['as' => 'api.admin.advertisements.contacts.update', 'uses' => 'ContactController@update']);
                    $api->delete('/{advertising_contact}', ['as' => 'api.admin.advertisements.contacts.delete', 'uses' => 'ContactController@delete']);
                });

                $api->group(['prefix' => 'companies'], function(Router $api) {
                    $api->get('/', ['as' => 'api.admin.advertisements.companies.index', 'uses' => 'CompanyController@index']);
                    $api->post('/', ['as' => 'api.admin.advertisements.companies.store', 'uses' => 'CompanyController@store']);
                    $api->get('/{advertising_company}', ['as' => 'api.admin.advertisements.companies.show', 'uses' => 'CompanyController@show']);
                    $api->put('/{advertising_company}', ['as' => 'api.admin.advertisements.companies.update', 'uses' => 'CompanyController@update']);
                    $api->delete('/{advertising_company}', ['as' => 'api.admin.advertisements.companies.delete', 'uses' => 'CompanyController@delete']);
                });

                $api->get('/', ['as' => 'api.admin.advertisements.index', 'uses' => 'AdvertisementController@index']);
                $api->post('/', ['as' => 'api.admin.advertisements.store', 'uses' => 'AdvertisementController@store']);
                $api->get('/{advertisement}', ['as' => 'api.admin.advertisements.show', 'uses' => 'AdvertisementController@show']);
                $api->put('/{advertisement}', ['as' => 'api.admin.advertisements.update', 'uses' => 'AdvertisementController@update']);
                $api->delete('/{advertisement}', ['as' => 'api.admin.advertisements.delete', 'uses' => 'AdvertisementController@delete']);
            });
        });
    });
});
