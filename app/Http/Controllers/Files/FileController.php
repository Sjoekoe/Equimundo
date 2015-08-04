<?php
namespace EQM\Http\Controllers\Files;

use EQM\Models\Pictures\Picture;
use Illuminate\Routing\Controller;
use Storage;

class FileController extends Controller
{
    /**
     * @param int $horseId
     * @param string $path
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getImage($horseId, $path)
    {
        $image = Picture::where('path', $path)->firstOrFail();

        $file = Storage::disk()->get('/uploads/pictures/' . $horseId . '/' . $path);

        return response($file, 200, ['Content-Type' => $image->mime]);
    }
}