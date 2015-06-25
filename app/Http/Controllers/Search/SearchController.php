<?php
namespace HorseStories\Http\Controllers\Search;

use HorseStories\Models\Horses\HorseRepository;
use Illuminate\Routing\Controller;
use Input;

class SearchController extends Controller
{
    /**
     * @var \HorseStories\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \HorseStories\Models\Horses\HorseRepository $horses
     */
    public function __construct(HorseRepository $horses)
    {
        $this->horses = $horses;
    }

    public function index()
    {
        $results = $this->horses->search(Input::get('search'));

        return view('searches.index', compact('results'));
    }

    public function search()
    {
        return redirect()->route('search.index', ['search' => Input::get('search')]);
    }
}
