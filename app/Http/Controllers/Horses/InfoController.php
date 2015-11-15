<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;

class InfoController extends Controller
{
    public function index(Horse $horse)
    {
        return view('horses.info.index', compact('horse'));
    }
}
