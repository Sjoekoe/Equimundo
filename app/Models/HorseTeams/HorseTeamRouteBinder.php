<?php
namespace EQM\Models\HorseTeams;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class HorseTeamRouteBinder extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\HorseTeams\HorseTeamRepository
     */
    private $horseTeams;

    /**
     * @param \EQM\Models\HorseTeams\HorseTeamRepository $horseTeams
     */
    public function __construct(HorseTeamRepository $horseTeams)
    {
        $this->horseTeams = $horseTeams;
    }

    /**
     * @param int|string $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->horseTeams->findById($id);
    }
}
