<?php
namespace HorseStories\Http\Controllers\Horses;

use HorseStories\Http\Controllers\Controller;
use HorseStories\Models\Horses\Horse;

class PicturesController extends Controller
{
    public function index($horseSlug)
    {
        $horse = Horse::with('pictures')->where('slug', $horseSlug)->firstOrFail();

        return view('horses.pictures.index', compact('horse'));
    }
}
