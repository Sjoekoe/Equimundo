<?php

get('picture/{picture}', ['as' => 'file.picture', 'uses' => 'FileController@getImage']);
