<?php
namespace EQM\Http\Controllers\Search;

use EQM\Events\SearchWasPerformed;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Users\UserRepository;
use Illuminate\Database\Eloquent\Collection;
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
        $searchWord = $request->get('search');
        $horseCollections = collect($this->horses->search($searchWord)['hits']);
        $profileCollections = collect($this->users->search($searchWord)['hits']);

        $horses = new Collection();
        $profiles = new Collection();

        foreach ($horseCollections as $horseCollection) {
            $horse = $this->horses->findById($horseCollection['id']);
            $horses->add($horse);
        }

        foreach ($profileCollections as $profileCollection) {
            $profile = $this->users->findById($profileCollection['id']);
            $profiles->add($profile);
        }

        $count = count($horses) + count($profiles);
        event(new SearchWasPerformed($request->get('search'), $count));

        return view('searches.index', compact('horses', 'profiles', 'searchWord', 'count'));
    }

    public function search()
    {
        return redirect()->route('search.index', ['search' => Input::get('search')]);
    }
}
