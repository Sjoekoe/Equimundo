<?php
namespace EQM\Http\Controllers\Files;

use EQM\Models\Pictures\Picture;
use EQM\Models\Pictures\PictureRepository;
use Illuminate\Routing\Controller;
use Storage;

class FileController extends Controller
{
    /**
     * @var \EQM\Models\Pictures\PictureRepository
     */
    private $pictures;

    public function __construct(PictureRepository $pictures)
    {
        $this->pictures = $pictures;
    }

    public function getImage(Picture $picture)
    {
        $file = Storage::disk()->get('/uploads/pictures/' . $picture->horse()->id() . '/' . $picture->path());

        return response($file, 200, ['Content-Type' => $picture->mime()]);
    }

    public function getMovie(Picture $picture)
    {
        $file = Storage::disk()->get('/uploads/pictures/' . $picture->horse()->id() . '/' . $picture->path());

        return response($file, 200, ['Content-Type' => $picture->mime()]);
    }
}
