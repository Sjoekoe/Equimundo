<?php
namespace EQM\Http\Controllers\Albums;

use EQM\Http\Controllers\Controller;
use EQM\Models\Albums\Album;
use EQM\Models\Albums\AlbumCreator;
use EQM\Models\Albums\AlbumDeleter;
use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Albums\AlbumRequest;
use EQM\Models\Horses\Horse;

class AlbumController extends Controller
{
    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    public function __construct(AlbumRepository $albums) {
        $this->albums = $albums;
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

    public function store(AlbumRequest $request, AlbumCreator $creator, Horse $horse)
    {
        $this->authorize('create-album', $horse);

        $creator->create($horse, $request);

        session()->put('success', 'Album Created');

        return redirect()->route('horses.pictures.index', $horse->slug());
    }

    public function edit(Album $album)
    {
        $this->authorize('edit-album', $album->horse());

        return view('albums.edit', compact('album'));
    }

    public function update(AlbumRequest $request, Album $album)
    {
        $this->authorize('edit-album', $album->horse());

        $this->albums->update($album, $request->all());

        session()->put('succes', 'Album updated');

        return redirect()->route('album.show', $album->id());
    }

    public function delete(AlbumDeleter $deleter, Album $album)
    {
        $this->authorize('delete-album', $album->horse());

        $deleter->delete($album);

        return redirect()->route('horses.pictures.index', $album->horse()->slug);
    }
}
