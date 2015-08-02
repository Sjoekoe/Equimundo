<?php
namespace EQM\Http\Controllers\Albums;

use EQM\Core\Files\Uploader;
use EQM\Http\Controllers\Controller;
use EQM\Http\Requests\AlbumRequest;
use EQM\Models\Albums\AlbumCreator;
use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Albums\AlbumUpdater;
use EQM\Models\Horses\HorseRepository;
use Illuminate\Auth\AuthManager;
use Input;
use Session;

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
     * @var \EQM\Models\Albums\AlbumCreator
     */
    private $creator;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \EQM\Models\Albums\AlbumUpdater
     */
    private $updater;

    /**
     * @param \EQM\Models\Albums\AlbumRepository $albums
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \Illuminate\Auth\AuthManager $auth
     * @param \EQM\Models\Albums\AlbumCreator $creator
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Models\Albums\AlbumUpdater $updater
     */
    public function __construct(
        AlbumRepository $albums,
        HorseRepository $horses,
        AuthManager $auth,
        AlbumCreator $creator,
        Uploader $uploader,
        AlbumUpdater $updater
    ) {
        $this->albums = $albums;
        $this->horses = $horses;
        $this->auth = $auth;
        $this->creator = $creator;
        $this->uploader = $uploader;
        $this->updater = $updater;
    }

    /**
     * @param int $albumId
     * @return \Illuminate\View\View
     */
    public function show($albumId)
    {
        $album = $this->albums->findById($albumId);

        $horse = $album->horse;

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
     * @param \EQM\Http\Requests\AlbumRequest $request
     * @param string $horseSlug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AlbumRequest $request, $horseSlug)
    {
        $horse = $this->initHorse($horseSlug);

        $album = $this->creator->create($horse, $request->all());

        if (array_key_exists('pictures', Input::all())) {
            $pictures = Input::file('pictures');

            foreach ($pictures as $picture) {
                $picture = $this->uploader->uploadPicture($picture, $horse);
                $picture->addToAlbum($album->id);
            }
        }

        Session::put('success', 'Album Created');

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
     * @param \EQM\Http\Requests\AlbumRequest $request
     * @param $albumId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AlbumRequest $request, $albumId)
    {
        $album = $this->initAlbum($albumId);

        $this->updater->update($album, $request->all());

        Session::put('succes', 'Album updated');

        return redirect()->route('album.show', $album->id);
    }

    /**
     * @param int $albumId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($albumId)
    {
        $album = $this->initAlbum($albumId);

        $album->delete();

        return redirect()->route('horses.pictures.index', $album->horse->slug);
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

        App::abort(403);
    }

    /**
     * @param int $albumId
     * @return \EQM\Models\Albums\Album
     */
    private function initAlbum($albumId)
    {
        $album = $this->albums->findById($albumId);

        if ($this->auth->user()->isHorseOwner($album->horse)) {
            return $album;
        }

        App::abort(403);
    }
}
