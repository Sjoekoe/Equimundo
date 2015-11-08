<?php
namespace EQM\Http\Controllers\Search;

use EQM\Models\Horses\HorseRepository;
use EQM\Models\Users\UserRepository;
use Illuminate\Routing\Controller;
use Input;

class SearchController extends Controller
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Users\UserRepository $users
     */
    public function __construct(HorseRepository $horses, UserRepository $users)
    {
        $this->horses = $horses;
        $this->users = $users;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $horses = $this->horses->search(Input::get('search'));

        $profiles = $this->users->search(Input::get('search'));

        return view('searches.index', compact('horses', 'profiles'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        return redirect()->route('search.index', ['search' => Input::get('search')]);
    }
}
