<?php

use EQM\Models\HorseTeams\HorseTeam;

return [
    'type' => [
        HorseTeam::OWNER => 'Owner',
        HorseTeam::RIDER => 'Rider',
        HorseTeam::GROOM => 'Groom',
        HorseTeam::TRAINER => 'Trainer',
    ],
];
