<?php

get('/', ['as' => 'home', 'uses' => 'PagesController@home', 'middleware' => 'auth']);
