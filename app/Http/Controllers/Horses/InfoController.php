<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Models\Horses\Horse;
use Illuminate\Routing\Controller;

class InfoController extends Controller
{
    public function index($horseSlug)
    {
        $horse = Horse::where('slug' , $horseSlug)->firstOrFail();

        return view('horses.info.index', compact('horse'));
    }
}