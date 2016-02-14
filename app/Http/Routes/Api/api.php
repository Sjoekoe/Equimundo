<?php

route::get('/api/horses/{horse}', ['as' => 'api.horses.show', 'uses' => 'HorseController@show']);
