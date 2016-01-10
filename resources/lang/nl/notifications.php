<?php

use EQM\Models\Notifications\Notification;

return [
    Notification::STATUS_LIKED => ':sender vindt een status van :horse leuk.',
    Notification::COMMENT_POSTED => ':sender heeft gereageerd op een status van :horse.',
    Notification::PEDIGREE_CREATED => ':family is toegevoegd aan de stamboom van :horse.',
    Notification::COMMENT_LIKED => ':liker vindt je commentaar leuk.',
];
