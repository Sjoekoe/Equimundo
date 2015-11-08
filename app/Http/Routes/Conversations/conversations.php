<?php

get('conversations', ['as' => 'conversation.index', 'uses' => 'ConversationController@index', 'middleware' => 'auth']);
get('conversations/create', ['as' => 'conversation.create', 'uses' => 'ConversationController@create', 'middleware' => 'auth']);
post('conversations/create', ['as' => 'conversation.store', 'uses' => 'ConversationController@store', 'middleware' => 'auth']);
get('conversations/show/{conversation}', ['as' => 'conversation.show', 'uses' => 'ConversationController@show', 'middleware' => 'auth']);
get('conversation/delete/{conversation}', ['as' => 'conversation.delete', 'uses' => 'ConversationController@delete', 'middleware' => 'auth']);
