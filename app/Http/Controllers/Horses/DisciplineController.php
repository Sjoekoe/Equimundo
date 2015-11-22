<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Disciplines\DisciplineResolver;
use EQM\Models\Horses\Horse;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    public function index(Horse $horse)
    {
        $this->authorize('create-disciplines', $horse);

        return view('disciplines.create', compact('horse'));
    }

    public function store(Request $request, DisciplineResolver $resolver, Horse $horse)
    {
        $this->authorize('create-disciplines', $horse);

        $resolver->resolve($horse, $request->all());

        return back();
    }
}
