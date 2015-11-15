<?php
namespace EQM\Http\Controllers\Search;

use EQM\Models\Horses\HorseRepository;
use EQM\Models\Users\UserRepository;
use Illuminate\Http\Request;
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

    public function __construct(HorseRepository $horses, UserRepository $users)
    {
        $this->horses = $horses;
        $this->users = $users;
    }

    // todo add validation
    public function index(Request $request)
    {
        $horses = $this->horses->search($request->get('search'));
        $profiles = $this->users->search($request->get('search'));

        return view('searches.index', compact('horses', 'profiles'));
    }

    public function search()
    {
        return redirect()->route('search.index', ['search' => Input::get('search')]);
    }
}
