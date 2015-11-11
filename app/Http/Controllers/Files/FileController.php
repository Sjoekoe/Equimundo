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

    /**
     * @param \EQM\Models\Pictures\PictureRepository $pictures
     */
    public function __construct(PictureRepository $pictures)
    {
        $this->pictures = $pictures;
    }

    /**
     * @param \EQM\Models\Pictures\Picture $picture
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getImage(Picture $picture)
    {
        $file = Storage::disk()->get('/uploads/pictures/' . $picture->horse()->id() . '/' . $picture->path());

        return response($file, 200, ['Content-Type' => $picture->mime()]);
    }
}
