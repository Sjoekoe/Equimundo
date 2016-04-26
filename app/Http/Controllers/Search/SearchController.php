<?php
namespace EQM\Http\Controllers\Search;

use EQM\Events\SearchWasPerformed;
use EQM\Models\Companies\CompanyRepository;
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

    /**
     * @var \EQM\Models\Companies\CompanyRepository
     */
    private $companies;

    public function __construct(HorseRepository $horses, UserRepository $users, CompanyRepository $companies)
    {
        $this->horses = $horses;
        $this->users = $users;
        $this->companies = $companies;
    }

    // todo add validation
    public function index(Request $request)
    {
        $searchWord = $request->get('search');
        $horseCollections = collect($this->horses->search($searchWord)['hits']);
        $profileCollections = collect($this->users->search($searchWord)['hits']);
        $companyCollections = collect($this->companies->search($searchWord)['hits']);

        $horses = new Collection();
        $profiles = new Collection();
        $companies = new Collection();

        foreach ($horseCollections as $horseCollection) {
            $horse = $this->horses->findById($horseCollection['id']);
            $horses->add($horse);
        }

        foreach ($profileCollections as $profileCollection) {
            $profile = $this->users->findById($profileCollection['id']);
            $profiles->add($profile);
        }
        
        foreach ($companyCollections as $companyCollection) {
            $company = $this->companies->findById($companyCollection['id']);
            $companies->add($company);
        }

        $count = count($horses) + count($profiles) + count($companies);
        event(new SearchWasPerformed($request->get('search'), $count));

        return view('searches.index', compact('horses', 'profiles', 'searchWord', 'count', 'companies'));
    }

    public function search()
    {
        return redirect()->route('search.index', ['search' => Input::get('search')]);
    }
}
