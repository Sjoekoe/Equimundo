<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;

class PicturesController extends Controller
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    /**
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Albums\AlbumRepository $albums
     */
    public function __construct(HorseRepository $horses, AlbumRepository $albums)
    {
        $this->horses = $horses;
        $this->albums = $albums;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\View\View
     */
    public function index(Horse $horse)
    {
        $albums = $this->albums->findForHorse($horse);

        return view('horses.pictures.index', compact('horse', 'albums'));
    }
}
