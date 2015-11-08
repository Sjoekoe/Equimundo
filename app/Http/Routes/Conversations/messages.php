<?php

post('message/{conversation}/create', ['as' => 'message.store', 'uses' => 'MessageController@store', 'middleware' => 'auth']);
