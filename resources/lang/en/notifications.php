<?php

use EQM\Models\Notifications\Notification;

return [
    Notification::STATUS_LIKED => ':sender has liked the status of :horse.',
    Notification::COMMENT_POSTED => ':sender has commented on a status of :horse.',
    Notification::PEDIGREE_CREATED => ':family horse was added to the pedigree of :horse.',
    Notification::COMMENT_LIKED => ':liker has liked your comment.',
    Notification::HORSE_FOLLOWED => ':follower is now following :horse',
];
