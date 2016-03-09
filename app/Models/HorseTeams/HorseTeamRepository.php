<?php
namespace EQM\Models\HorseTeams;

use EQM\Models\Horses\Horse;
use EQM\Models\Users\User;

interface HorseTeamRepository
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Horses\Horse $horse
     * @param int $type
     * @return \EQM\Models\HorseTeams\HorseTeam
     */
    public function create(User $user, Horse $horse, $type);

    /**
     * @param \EQM\Models\HorseTeams\HorseTeam $horseTeam
     */
    public function delete(HorseTeam $horseTeam);

    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\HorseTeams\HorseTeam
     */
    public function createOwner(User $user, Horse $horse);

    /**
     * @param int $id
     * @return \EQM\Models\HorseTeams\HorseTeam
     */
    public function findById($id);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\HorseTeams\HorseTeam
     */
    public function findByHorseAndUser(Horse $horse, User $user);
}
