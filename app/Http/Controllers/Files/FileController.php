<?php
namespace EQM\Http\Controllers\Files;

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
     * @param int $horseId
     * @param string $path
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getImage($horseId, $path)
    {
        $image = $this->pictures->findByPath($path);

        $file = Storage::disk()->get('/uploads/pictures/' . $horseId . '/' . $path);

        return response($file, 200, ['Content-Type' => $image->mime]);
    }
}
