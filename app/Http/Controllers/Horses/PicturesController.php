<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;

class PicturesController extends Controller
{
    public function index($horseSlug)
    {
        $horse = Horse::with('pictures')->where('slug', $horseSlug)->firstOrFail();

        return view('horses.pictures.index', compact('horse'));
    }
}
