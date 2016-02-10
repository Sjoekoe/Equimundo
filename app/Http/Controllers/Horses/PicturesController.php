<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Core\Files\Uploader;
use EQM\Http\Controllers\Controller;
use EQM\Models\Albums\Album;
use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Horses\Horse;
use Illuminate\Http\Request;

class PicturesController extends Controller
{
    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    public function __construct(AlbumRepository $albums, Uploader $uploader)
    {
        $this->albums = $albums;
        $this->uploader = $uploader;
    }

    public function index(Horse $horse)
    {
        $albums = $this->albums->findForHorse($horse);

        return view('horses.pictures.index', compact('horse', 'albums'));
    }

    public function uploadHeaderImage(Request $request, Horse $horse)
    {
        $picture = $this->uploader->uploadPicture($request->file('header_picture'), $horse);

        $album = $horse->getStandardAlbum(Album::COVERPICTURES);
        $picture->addToAlbum($album);

        if ($horse->getHeaderImage()) {
            $image = $horse->getHeaderImage();
            $image->header_image = false;
            $image->save();
        }

        $picture->header_image = true;
        $picture->save();

        return back();
    }
}
