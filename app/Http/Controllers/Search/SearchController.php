<?php
namespace HorseStories\Http\Controllers\Search;

use HorseStories\Models\Horses\HorseRepository;
use HorseStories\Models\Users\UserRepository;
use Illuminate\Routing\Controller;
use Input;

class SearchController extends Controller
{
    /**
     * @var \HorseStories\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \HorseStories\Models\Users\UserRepository
     */
    private $users;

    /**
     * @param \HorseStories\Models\Horses\HorseRepository $horses
     * @param \HorseStories\Models\Users\UserRepository $users
     */
    public function __construct(HorseRepository $horses, UserRepository $users)
    {
        $this->horses = $horses;
        $this->users = $users;
    }

    public function index()
    {
        $horses = $this->horses->search(Input::get('search'));

        $profiles = $this->users->search(Input::get('search'));

        return view('searches.index', compact('horses', 'profiles'));
    }

    public function search()
    {
        return redirect()->route('search.index', ['search' => Input::get('search')]);
    }
}
