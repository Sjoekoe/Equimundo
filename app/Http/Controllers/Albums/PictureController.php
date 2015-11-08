<?php
namespace EQM\Http\Controllers\Albums;

use EQM\Core\Files\Uploader;
use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Pictures\PictureRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use Input;
use Storage;

class PictureController extends Controller
{
    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \EQM\Models\Pictures\EloquentPictureRepository
     */
    private $pictures;

    /**
     * @param \EQM\Models\Albums\AlbumRepository $albums
     * @param \Illuminate\Auth\AuthManager $auth
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Models\Pictures\PictureRepository $pictures
     */
    public function __construct(AlbumRepository $albums, AuthManager $auth, Uploader $uploader, PictureRepository $pictures)
    {
        $this->albums = $albums;
        $this->auth = $auth;
        $this->uploader = $uploader;
        $this->pictures = $pictures;
    }

    /**
     * @param int $albumId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create($albumId)
    {
        $album = $this->initAlbum($albumId);

        $pictures = Input::file('pictures');

        foreach ($pictures as $picture) {
            $picture = $this->uploader->uploadPicture($picture, $album->horse());

            $picture->addToAlbum($album);
        }

        session()->put('success', 'Pictures uploaded');

        return redirect()->back();
    }

    /**
     * @param int $albumId
     * @param int $pictureId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($albumId, $pictureId)
    {
        $album = $this->initAlbum($albumId);

        $picture = $this->pictures->findById($pictureId);

        if (count($picture->albums()) > 1) {
            $picture->removeFromAlbum($album);

            session()->put('success', 'Picture removed from album');
        } else {
            Storage::delete('/uploads/pictures/' . $picture->horse->id . '/' . $picture->path());

            $picture->delete();

            session()->put('succes', 'Picture deleted');
        }

        return redirect()->route('album.show', $album->id);
    }

    /**
     * @param int $albumId
     * @return \EQM\Models\Albums\Album
     */
    private function initAlbum($albumId)
    {
        $album = $this->albums->findById($albumId);

        if ($this->auth->user()->isInHorseTeam($album->horse())) {
            return $album;
        }

        abort(403);
    }
}
