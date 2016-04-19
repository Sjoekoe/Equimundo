<?php

Route::get('conversations', ['as' => 'conversation.index', 'uses' => 'ConversationController@index', 'middleware' => 'auth']);
Route::get('conversations/create', ['as' => 'conversation.create', 'uses' => 'ConversationController@create', 'middleware' => 'auth']);
Route::post('conversations/create', ['as' => 'conversation.store', 'uses' => 'ConversationController@store', 'middleware' => 'auth']);
Route::get('conversations/show/{conversation}', ['as' => 'conversation.show', 'uses' => 'ConversationController@show', 'middleware' => 'auth']);
Route::get('conversation/delete/{conversation}', ['as' => 'conversation.delete', 'uses' => 'ConversationController@delete', 'middleware' => 'auth']);
