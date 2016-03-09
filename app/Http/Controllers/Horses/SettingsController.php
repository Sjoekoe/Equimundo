<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\HorseTeams\HorseTeamRepository;

class SettingsController extends Controller
{
    /**
     * @var \EQM\Models\HorseTeams\HorseTeamRepository
     */
    private $horseTeams;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    public function __construct(HorseTeamRepository $horseTeams, HorseRepository $horses)
    {
        $this->horseTeams = $horseTeams;
        $this->horses = $horses;
    }

    public function index()
    {
        return view('horses.settings.index');
    }

    public function unlink(Horse $horse)
    {
        $this->authorize('unlink', $horse);

        $horseTeam = $this->horseTeams->findByHorseAndUser($horse, auth()->user());

        $this->horseTeams->delete($horseTeam);

        return redirect()->back();
    }

    public function delete(Horse $horse)
    {
        $this->authorize('delete-horse', $horse);

        $this->horses->delete($horse);

        return redirect()->back();
    }
}
