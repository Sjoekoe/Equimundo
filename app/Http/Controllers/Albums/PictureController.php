<?php
namespace EQM\Http\Controllers\Albums;

use EQM\Http\Controllers\Controller;
use EQM\Http\Requests\Request;
use EQM\Models\Albums\Album;
use EQM\Models\Pictures\Picture;
use EQM\Models\Pictures\PictureCreator;

class PictureController extends Controller
{
    // todo add validation
    public function store(Request $request, PictureCreator $creator, Album $album)
    {
        $this->authorize('upload-picture', $album->horse());

        $creator->create($album, $request);

        session()->put('success', 'Pictures uploaded');

        return redirect()->back();
    }

    public function delete(Album $album, Picture $picture)
    {
        $this->authorize('delete-picture', $picture->horse());

        $message = count($picture->albums()) > 1 ? 'Picture removed from album' : 'Picture removed from album';

        session()->put('success', $message);

        return redirect()->route('album.show', $album->id);
    }
}
