<?php
use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', function(Router $api) {
    $api->group(['namespace' => 'EQM\\Api\\Http\\Controllers\\'], function (Router $api) {
        $api->post('/addresses', ['as' => 'api.addresses.create', 'uses' => 'AddressController@create']);

        $api->group(['namespace' => 'Wiki\\', 'prefix' => 'topics'], function(Router $api) {
            $api->get('/', ['as' => 'topics.index', 'uses' => 'TopicController@index']);
            $api->post('/', ['as' => 'topics.store', 'uses' => 'TopicController@store']);
            $api->get('/{topic}', ['as' => 'topics.show', 'uses' => 'TopicController@show']);
            $api->put('/{topic}', ['as' => 'topics.update', 'uses' => 'TopicController@update']);
            $api->delete('/{topic}', ['as' => 'topics.delete', 'uses' => 'TopicController@delete']);

            $api->group(['prefix' => '{topic}/articles'], function (Router $api) {
                $api->get('/', ['as' => 'articles.index', 'uses' => 'ArticleController@index']);
                $api->post('/', ['as' => 'articles.store', 'uses' => 'ArticleController@store']);
                $api->get('/{article}', ['as' => 'articles.show', 'uses' => 'ArticleController@show']);
                $api->put('/{article}', ['as' => 'articles.update', 'uses' => 'ArticleController@update']);
                $api->delete('/{article}', ['as' => 'articles.delete', 'uses' => 'ArticleController@delete']);
            });
        });

        $api->get('/users/{user}', ['as' => 'api.users.show', 'uses' => 'UserController@show']);
        $api->put('/users/{user}', ['as' => 'api.users.update', 'uses' => 'UserController@update']);
        $api->get('/users/{user}/horses', ['as' => 'api.users.horses.index', 'uses' => 'HorseController@index']);
        $api->get('/users/{user}/feed', ['as' => 'api.users.feed', 'uses' => 'UserController@feed']);
        $api->get('/users/{user}/notifications/reset-count', ['as' => 'api.users.notifications.reset_count', 'uses' => 'NotificationController@resetCount']);

        $api->get('/horses/{horse}', ['as' => 'api.horses.show', 'uses' => 'HorseController@show']);
        $api->get('/horses/{horse}/statuses', ['as' => 'api.horses.statuses.index', 'uses' => 'HorseStatusController@index']);

        $api->get('/follows/{horse}', ['as' => 'follows.store', 'uses' => 'FollowsController@store']);

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

        $api->post('/comments/{comment}/like', ['as' => 'comments.like', 'uses' => 'LikeController@likeComment']);

        $api->get('/notifications', ['as' => 'api.notifications.index', 'uses' => 'NotificationController@index']);
        $api->get('/notifications/mark-as-read', ['as' => 'api.notifications.read', 'uses' => 'NotificationController@markRead']);
        $api->get('/notifications/{notification}', ['as' => 'api.notifications.show', 'uses' => 'NotificationController@show']);
        $api->delete('/notifications/{notification}', ['as' => 'api.notifications.delete', 'uses' => 'NotificationController@delete']);

        $api->group(['namespace' => 'Companies\\', 'prefix' => 'companies'], function (Router $api) {
            $api->get('/', ['as' => 'api.companies.index', 'uses' => 'CompanyController@index']);
            $api->post('/', ['as' => 'api.companies.store', 'uses' => 'CompanyController@store']);
            $api->get('/{company}', ['as' => 'api.companies.show', 'uses' => 'CompanyController@show']);
            $api->put('/{company}', ['as' => 'api.companies.update', 'uses' => 'CompanyController@update']);
            $api->delete('/{company}', ['as' => 'api.companies.delete', 'uses' => 'CompanyController@delete']);

            $api->get('/{company}/users', ['as' => 'api.companies.users.index', 'uses' => 'CompanyUserController@index']);
            $api->post('/{company}/users', ['as' => 'api.companies.users.store', 'uses' => 'CompanyUserController@store']);
            $api->get('/{company}/users/{user}', ['as' => 'api.companies.users.show', 'uses' => 'CompanyUserController@show']);
            $api->delete('/{company}/users/{user}', ['as' => 'api.companies.delete', 'uses' => 'CompanyUserController@delete']);

            $api->get('/{company}/horses', ['as' => 'api.companies.horses.index', 'uses' => 'CompanyHorseController@index']);
            $api->post('/{company}/horses', ['as' => 'api.companies.horses.store', 'uses' => 'CompanyHorseController@store']);
            $api->get('/{company}/horses/{horse}', ['as' => 'api.companies.horses.show', 'uses' => 'CompanyHorseController@show']);
            $api->delete('/{company}/horses/{horse}', ['as' => 'api.companies.horses.delete', 'uses' => 'CompanyHorseController@delete']);

            $api->get('/{company}/statuses', ['as' => 'api.companies.statuses.index', 'uses' => 'CompanyStatusController@index']);
            $api->post('/{company}/statuses', ['as' => 'api.companies.statuses.store', 'uses' => 'CompanyStatusController@store']);
        });

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
                $api->get('/random', ['as' => 'api.admin.advertisements.random', 'uses' => 'AdvertisementController@random']);
                $api->get('/{advertisement}', ['as' => 'api.admin.advertisements.show', 'uses' => 'AdvertisementController@show']);
                $api->put('/{advertisement}', ['as' => 'api.admin.advertisements.update', 'uses' => 'AdvertisementController@update']);
                $api->delete('/{advertisement}', ['as' => 'api.admin.advertisements.delete', 'uses' => 'AdvertisementController@delete']);
            });
        });

        $api->group(['namespace' => 'Conversations\\', 'prefix' => 'conversations'], function (Router $api) {
            $api->group(['namespace' => 'Messages\\', 'prefix' => '{conversation}/messages'], function (Router $api) {
                $api->get('/', ['as' => 'conversation.messages.index', 'uses' => 'MessageController@index']);
                $api->post('/', ['as' => 'conversation.messages.store', 'uses' => 'MessageController@store']);
            });
        });
    });
});
