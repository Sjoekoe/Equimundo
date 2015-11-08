<?php

use EQM\Models\HorseTeams\HorseTeam;

return [
    'type' => [
        HorseTeam::OWNER => 'Eigenaar',
        HorseTeam::RIDER => 'Ruiter',
        HorseTeam::GROOM => 'Groom',
        HorseTeam::TRAINER => 'Trainer',
    ],
];
