<?php
namespace EQM\Http\Controllers\Albums;

use EQM\Core\Files\Uploader;
use EQM\Http\Controllers\Controller;
use EQM\Models\Albums\Album;
use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Albums\AlbumRequest;
use EQM\Models\Horses\Horse;
use Illuminate\Auth\AuthManager;
use Storage;

class AlbumController extends Controller
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

    public function __construct(AlbumRepository $albums, AuthManager $auth, Uploader $uploader) {
        $this->albums = $albums;
        $this->auth = $auth;
        $this->uploader = $uploader;
    }

    public function show(Album $album)
    {
        $horse = $album->horse();

        return view('albums.show', compact('album', 'horse'));
    }

    public function create(Horse $horse)
    {
        $this->authorize('create-album', $horse);

        return view('albums.create', compact('horse'));
    }

    public function store(AlbumRequest $request, Horse $horse)
    {
        $this->authorize('create-album', $horse);

        $album = $this->albums->create($horse, $request->all());

        if (array_key_exists('pictures', $request->all())) {
            $pictures = $request->file('pictures');

            foreach ($pictures as $picture) {
                $picture = $this->uploader->uploadPicture($picture, $horse);
                $picture->addToAlbum($album);
            }
        }

        session()->put('success', 'Album Created');

        return redirect()->route('horses.pictures.index', $horse->slug);
    }

    /**
     * @param \EQM\Models\Albums\Album $album
     * @return \Illuminate\View\View
     */
    public function edit(Album $album)
    {
        $this->authorize('edit-album', $album->horse());

        return view('albums.edit', compact('album'));
    }

    /**
     * @param \EQM\Models\Albums\AlbumRequest $request
     * @param \EQM\Models\Albums\Album $album
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AlbumRequest $request, Album $album)
    {
        $this->authorize('edit-album', $album->horse());

        $this->albums->update($album, $request->all());

        session()->put('succes', 'Album updated');

        return redirect()->route('album.show', $album->id());
    }

    /**
     * @param \EQM\Models\Albums\Album $album
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Album $album)
    {
        $this->authorize('delete-album', $album->horse());

        foreach ($album->pictures() as $picture) {
            if (count($picture->albums()) > 1) {
                $picture->removeFromAlbum($album);
            } else {
                Storage::delete('/uploads/pictures/' . $picture->horse()->id() . '/' . $picture->path());

                $picture->delete();
            }
        }

        $this->albums->delete($album);

        return redirect()->route('horses.pictures.index', $album->horse()->slug);
    }
}
