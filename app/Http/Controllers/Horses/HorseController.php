<?php
namespace EQM\Http\Controllers\Horses;

use DB;
use EQM\Core\Files\Uploader;
use EQM\Events\HorseWasCreated;
use EQM\Http\Requests\CreateHorse;
use EQM\Http\Requests\UpdateHorse;
use EQM\Models\Albums\Album;
use EQM\Models\Disciplines\DisciplineRepository;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\User;
use Illuminate\Routing\Controller;

class HorseController extends Controller
{
    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\Disciplines\DisciplineRepository
     */
    private $disciplines;

    /**
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\Disciplines\DisciplineRepository $disciplines
     */
    public function __construct(
        Uploader $uploader,
        HorseRepository $horses,
        StatusRepository $statuses,
        DisciplineRepository $disciplines
    ) {
        $this->uploader = $uploader;
        $this->horses = $horses;
        $this->statuses = $statuses;
        $this->disciplines = $disciplines;
    }

    /**
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function index($userId)
    {
        $user = User::with('horses')->where('id', $userId)->firstOrFail();

        return view('horses.index', compact('user'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $disciplines = trans('disciplines.list');

        return view('horses.create', compact('disciplines'));
    }

    /**
     * @param \EQM\Http\Requests\CreateHorse $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateHorse $request)
    {
        if ($request->has('life_number') && $horse = $this->horses->findByLifeNumber($request->get('life_number'))) {
            if ($horse->hasOwner()) {
                session(['error', 'This horse already has an owner. If you are the rightful owner, please contact us.']);

                return redirect()->back();
            }

            $horse = $this->horses->update($horse, $request->all());

            $this->resolveDisciplines($horse, $request->all());

            $horse->user_id = auth()->user()->id;

            $horse->save();
        } else {
            $horse = $this->horses->create(auth()->user(), $request->all());
        }

        event(new HorseWasCreated($horse));

        if ($request->hasFile('profile_pic')) {
            $picture = $this->uploader->uploadPicture($request->file('profile_pic'), $horse, true);

            $picture->addToAlbum($horse->getStandardAlbum(Album::PROFILEPICTURES));
        }

        session()->put('success', $horse->name . ' was successfully created.');

        return redirect()->route('horses.index', auth()->user()->id);
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $horse = $this->horses->findBySlug($slug);

        $statuses = $this->statuses->findFeedForHorse($horse);

        $likes = DB::table('likes')->whereUserId(auth()->user()->id)->lists('status_id');

        return view('horses.show', compact('horse', 'likes', 'statuses'));
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function edit($slug)
    {
        $horse = $this->initHorse($slug);

        $disciplines = trans('disciplines.list');

        return view('horses.edit', compact('horse', 'disciplines'));
    }

    /**
     * @param string $slug
     * @param \EQM\Http\Requests\UpdateHorse $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($slug, UpdateHorse $request)
    {
        $horse = $this->initHorse($slug);

        $horse = $this->horses->update($horse, $request->all());

        $this->resolveDisciplines($horse, $request->all());

        session(['success', $horse->name() . ' was updated']);

        return redirect()->route('horses.edit', $horse->slug());
    }

    /**
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($slug)
    {
        $horse = $this->initHorse($slug);

        session(['success', $horse->name . ' was deleted']);

        $horse->delete();

        return redirect()->route('home');
    }

    /**
     * @param string $slug
     * @return \EQM\Models\Horses\Horse
     */
    private function initHorse($slug)
    {
        $horse = $this->horses->findBySlug($slug);

        if (auth()->user()->isHorseOwner($horse)) {
            return $horse;
        }

        abort(403);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     */
    private function resolveDisciplines(Horse $horse, $values = [])
    {
        $initialDisciplines = [];
        $unwantedDisciplines = [];

        foreach ($horse->disciplines as $initialDiscipline) {
            $initialDisciplines[$initialDiscipline->id] = $initialDiscipline->discipline;
        }

        if (array_key_exists('disciplines', $values)) {
            foreach ($values['disciplines'] as $discipline) {
                $horse->disciplines()->updateOrCreate(['discipline' => $discipline, 'horse_id' => $horse->id]);
            }

            $unwantedDisciplines = array_diff($initialDisciplines, $values['disciplines']);
        }

        foreach ($unwantedDisciplines as $key => $values) {
            $this->disciplines->removeById($key);
        }
    }
}
