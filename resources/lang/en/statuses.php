<?php

use EQM\Models\Statuses\Status;

return [
    'prefixes' => [
        Status::PREFIX_PALMARES => 'has added an achievement',
        Status::PREFIX_JOINED_COMPANY => 'has joined a <a href=":link" class="text-mint">company / group</a>',
        Status::PREFIX_CREATED_ALBUM => 'has created a new <a href=":link" class="text-mint">album</a>',
        Status::PREFIX_ADDED_PICTURES => 'has added pictures to an <a href=":link" class="text-mint">album</a>',
    ]
];
