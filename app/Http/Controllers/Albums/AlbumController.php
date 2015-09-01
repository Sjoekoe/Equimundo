<?php
namespace EQM\Http\Controllers\Albums;

use EQM\Core\Files\Uploader;
use EQM\Http\Controllers\Controller;
use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Albums\AlbumRequest;
use EQM\Models\Horses\HorseRepository;
use Illuminate\Auth\AuthManager;
use Storage;

class AlbumController extends Controller
{
    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @param \EQM\Models\Albums\AlbumRepository $albums
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \Illuminate\Auth\AuthManager $auth
     * @param \EQM\Core\Files\Uploader $uploader
     */
    public function __construct(
        AlbumRepository $albums,
        HorseRepository $horses,
        AuthManager $auth,
        Uploader $uploader
    ) {
        $this->albums = $albums;
        $this->horses = $horses;
        $this->auth = $auth;
        $this->uploader = $uploader;
    }

    /**
     * @param int $albumId
     * @return \Illuminate\View\View
     */
    public function show($albumId)
    {
        $album = $this->albums->findById($albumId);

        $horse = $album->horse();

        return view('albums.show', compact('album', 'horse'));
    }

    /**
     * @param string $horseslug
     * @return \Illuminate\View\View
     */
    public function create($horseslug)
    {
        $horse = $this->initHorse($horseslug);

        return view('albums.create', compact('horse'));
    }

    /**
     * @param \EQM\Models\Albums\AlbumRequest $request
     * @param string $horseSlug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AlbumRequest $request, $horseSlug)
    {
        $horse = $this->initHorse($horseSlug);

        $album = $this->albums->create($horse, $request->all());

        if (array_key_exists('pictures', $request->all())) {
            $pictures = $request->file('pictures');

            foreach ($pictures as $picture) {
                $picture = $this->uploader->uploadPicture($picture, $horse);
                $picture->addToAlbum($album->id);
            }
        }

        session()->put('success', 'Album Created');

        return redirect()->route('horses.pictures.index', $horse->slug);
    }

    /**
     * @param int $albumId
     * @return \Illuminate\View\View
     */
    public function edit($albumId)
    {
        $album = $this->initAlbum($albumId);

        return view('albums.edit', compact('album'));
    }

    /**
     * @param \EQM\Models\Albums\AlbumRequest $request
     * @param $albumId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AlbumRequest $request, $albumId)
    {
        $album = $this->initAlbum($albumId);

        $this->albums->update($album, $request->all());

        session()->put('succes', 'Album updated');

        return redirect()->route('album.show', $album->id());
    }

    /**
     * @param int $albumId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($albumId)
    {
        $album = $this->initAlbum($albumId);

        foreach ($album->pictures() as $picture) {
            if (count($picture->albums) > 1) {
                $picture->removeFromAlbum($album->id());
            } else {
                Storage::delete('/uploads/pictures/' . $picture->horse->id . '/' . $picture->path);

                $picture->delete();
            }
        }

        $this->albums->delete($album);

        return redirect()->route('horses.pictures.index', $album->horse()->slug);
    }

    /**
     * @param string $horseslug
     * @return \EQM\Models\Horses\Horse
     */
    private function initHorse($horseslug)
    {
        $horse = $this->horses->findBySlug($horseslug);

        if ($this->auth->user()->isHorseOwner($horse)) {
            return $horse;
        }

        abort(403);
    }

    /**
     * @param int $albumId
     * @return \EQM\Models\Albums\Album
     */
    private function initAlbum($albumId)
    {
        $album = $this->albums->findById($albumId);

        if ($this->auth->user()->isHorseOwner($album->horse())) {
            return $album;
        }

        abort(403);
    }
}
