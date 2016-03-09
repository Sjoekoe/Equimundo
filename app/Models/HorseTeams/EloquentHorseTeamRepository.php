<?php
namespace EQM\Models\HorseTeams;

use EQM\Models\Horses\Horse;
use EQM\Models\Users\User;

class EloquentHorseTeamRepository implements HorseTeamRepository
{
    /**
     * @var \EQM\Models\HorseTeams\HorseTeam
     */
    private $horseTeam;

    /**
     * @param \EQM\Models\HorseTeams\HorseTeam $horseTeam
     */
    public function __construct(HorseTeam $horseTeam)
    {
        $this->horseTeam = $horseTeam;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Horses\Horse $horse
     * @param int $type
     * @return \EQM\Models\HorseTeams\HorseTeam
     */
    public function create(User $user, Horse $horse, $type)
    {
        $horseTeam = new EloquentHorseTeam();
        $horseTeam->user_id = $user->id();
        $horseTeam->horse_id = $horse->id();
        $horseTeam->type = $type;
        $horseTeam->save();

        return $horseTeam;
    }

    /**
     * @param \EQM\Models\HorseTeams\HorseTeam $horseTeam
     */
    public function delete(HorseTeam $horseTeam)
    {
        $horseTeam->delete();
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\HorseTeams\HorseTeam
     */
    public function createOwner(User $user, Horse $horse)
    {
        return $this->create($user, $horse, HorseTeam::OWNER);
    }

    /**
     * @param int $id
     * @return \EQM\Models\HorseTeams\HorseTeam
     */
    public function findById($id)
    {
        return $this->horseTeam->find($id);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\HorseTeams\HorseTeam
     */
    public function findByHorseAndUser(Horse $horse, User $user)
    {
        return $this->horseTeam
            ->where('user_id', $user->id())
            ->where('horse_id', $horse->id())
            ->first();
    }
}
