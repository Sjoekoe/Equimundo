<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Horses\Horse;

class PicturesController extends Controller
{
    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    public function __construct(AlbumRepository $albums)
    {
        $this->albums = $albums;
    }

    public function index(Horse $horse)
    {
        $albums = $this->albums->findForHorse($horse);

        return view('horses.pictures.index', compact('horse', 'albums'));
    }
}
