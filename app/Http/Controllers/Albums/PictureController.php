<?php
namespace EQM\Http\Controllers\Albums;

use EQM\Http\Controllers\Controller;
use EQM\Models\Albums\Album;
use EQM\Models\Pictures\Picture;
use EQM\Models\Pictures\PictureCreator;
use EQM\Models\Pictures\PictureRepository;
use EQM\Models\Pictures\Requests\AlbumPicturesRequest;
use Illuminate\Filesystem\Filesystem;
use Storage;

class PictureController extends Controller
{

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;

    /**
     * @var \EQM\Models\Pictures\PictureRepository
     */
    private $pictures;

    public function __construct(Filesystem $files, PictureRepository $pictures)
    {
        $this->files = $files;
        $this->pictures = $pictures;
    }

    // todo add validation
    public function store(AlbumPicturesRequest $request, PictureCreator $creator, Album $album)
    {
        $this->authorize('upload-picture', $album->horse());

        $creator->create($album, $request);

        session()->put('success', 'Pictures uploaded');

        return redirect()->back();
    }

    public function delete(Album $album, Picture $picture)
    {
        $this->authorize('delete-picture', $picture->horse());

        if (count($picture->albums()) > 1) {
            $picture->removeFromAlbum($album);
            $message = 'Picture removed from album';
        } else {
            Storage::disk()->delete('/uploads/pictures/' . $picture->horse()->id() . '/' . $picture->path());
            $message = 'Picture removed.';

            $this->pictures->delete($picture);
        }

        session()->put('success', $message);

        return redirect()->route('album.show', $album->id);
    }
}
