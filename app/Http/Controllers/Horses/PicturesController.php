<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Core\Files\Uploader;
use EQM\Http\Controllers\Controller;
use EQM\Models\Albums\Album;
use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Horses\Horse;
use EQM\Models\Pictures\Picture;
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
        $picture = $this->uploader->uploadPicture($request->file('header_picture'), $horse, false, true);

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

    public function setProfilePicture(Picture $picture)
    {
        $horse = $picture->horse();
        
        if ($old = $horse->getProfilePicture()) {
            $old->profile_pic = false;
            $old->save();
        }

        $picture->profile_pic = true;
        $picture->save();

        $profileAlbum = $horse->getStandardAlbum(Album::PROFILEPICTURES);

        $profilePictures = [];

        foreach ($profileAlbum->pictures() as $profilePicture) {
            array_push($profilePictures, $profilePicture->id());
        }

        if (! in_array($picture->id(), $profilePictures)) {
            $picture->addToAlbum($profileAlbum);
        }

        $picture->save();

        return back();
    }
}
