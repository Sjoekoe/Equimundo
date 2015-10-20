<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Models\Horses\EloquentHorse;
use Illuminate\Routing\Controller;

class InfoController extends Controller
{
    public function index($horseSlug)
    {
        $horse = EloquentHorse::where('slug' , $horseSlug)->firstOrFail();

        return view('horses.info.index', compact('horse'));
    }
}
