<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Horses\HorseRepository;
use Illuminate\Routing\Controller;

class InfoController extends Controller
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \EQM\Models\Horses\HorseRepository $horses
     */
    public function __construct(HorseRepository $horses)
    {
        $this->horses = $horses;
    }

    /**
     * @param string $horseSlug
     * @return \Illuminate\View\View
     */
    public function index($horseSlug)
    {
        $horse = $this->horses->findBySlug($horseSlug);

        return view('horses.info.index', compact('horse'));
    }
}
