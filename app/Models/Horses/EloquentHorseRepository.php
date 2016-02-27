<?php
namespace EQM\Models\Horses;

use Carbon\Carbon;
use DB;
use DateTime;
use EQM\Core\Slugs\SlugCreator;
use EQM\Models\Users\User;

class EloquentHorseRepository implements HorseRepository
{
    /**
     * @var \EQM\Models\Horses\EloquentHorse
     */
    private $horse;

    /**
     * @param \EQM\Models\Horses\EloquentHorse $horse
     * @param \EQM\Core\Slugs\SlugCreator $slugCreator
     */
    public function __construct(EloquentHorse $horse)
    {
        $this->horse = $horse;
    }

    /**
     * @param $id
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function findById($id)
    {
           return $this->horse->findOrFail($id);
    }

    /**
     * @param string $lifeNumber
     * @return \EQM\Models\Horses\EloquentHorse|null
     */
    public function findByLifeNumber($lifeNumber)
    {
        return $this->horse->where('life_number', $lifeNumber)->first();
    }

    /**
     * @param string $slug
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function findBySlug($slug)
    {
        return $this->horse->where('slug', $slug)->firstOrFail();
    }

    /**
     * @param string $slug
     * @return int
     */
    public function findSlugCounts($slug)
    {
        return count($this->horse->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get());
    }

    /**
     * @param string $value
     * @return \EQM\Models\Horses\EloquentHorse[]
     */
    public function search($value)
    {
        return $this->horse->where('name', 'like', '%' . $value . '%')->get();
    }

    /**
     * @param array $values
     * @param bool $pedigree
     * @return \EQM\Models\Horses\Horse
     */
    public function create(array $values = [], $pedigree = false)
    {
        $horse = new EloquentHorse();

        $horse->name = $values['name'];
        $horse->gender = $values['gender'];
        $horse->breed = $values['breed'];
        $horse->slug = (new SlugCreator())->createForHorse($values['name']);

        if (array_key_exists('life_number', $values)) {
            $horse->life_number = $values['life_number'];
        }

        if (array_key_exists('color', $values)) {
            $horse->color = $values['color'];
        }

        if (array_key_exists('date_of_birth', $values) && ! $values['date_of_birth'] == '') {
            if ($pedigree) {
                $horse->date_of_birth = Carbon::createFromFormat('Y', $values['date_of_birth'])->startOfYear();
            } else {
                $horse->date_of_birth = Carbon::createFromFormat('d/m/Y', $values['date_of_birth'])->startOfDay();
            }
        }

        if (array_key_exists('height', $values)) {
            $horse->height = $values['height'];
        }

        $horse->save();

        return $horse;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     * @return \EQM\Models\Horses\Horse
     */
    public function update(Horse $horse, array $values = [])
    {
        $horse->name = $values['name'];

        if (array_key_exists('gender', $values)) {
            $horse->gender = $values['gender'];
        }

        if (array_key_exists('breed', $values)) {
            $horse->breed = $values['breed'];
        }


        if (array_key_exists('height', $values)) {
            $horse->height = $values['height'];
        }

        if (array_key_exists('color', $values)) {
            $horse->color = $values['color'];
        }

        if (array_key_exists('date_of_birth', $values)) {
            $horse->date_of_birth = Carbon::createFromFormat('d/m/Y', $values['date_of_birth'])->startOfDay();
        }

        if (array_key_exists('life_number', $values)) {
            $horse->life_number = $values['life_number'];
        }

        $horse->save();

        return $horse;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Horses\Horse[]
     */
    public function findForUser(User $user)
    {
        return $this->horse
            ->join('horse_team', 'horses.id', '=', 'horse_team.horse_id')
            ->where('horse_team.user_id', $user->id)
            ->get();
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->horse->all());
    }

    /**
     * @param int $limit
     * @return \Eqm\Models\Horses\Horse[]
     */
    public function paginated($limit = 10)
    {
        return $this->horse->latest()->paginate($limit);
    }

    /**
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @return int
     */
    public function findCountByDate(Carbon $start, Carbon $end)
    {
        return count($this->horse->where('created_at', '>', $start)->where('created_at', '<', $end)->get());
    }

    /**
     * @param \Carbon\Carbon $date
     * @return int
     */
    public function findCreatedHorsesBeforeDate(Carbon $date)
    {
        return count($this->horse->where('created_at', '<=', $date)->get());
    }

    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function findMostActiveHorses()
    {
        $horses = $this->horse->get()->sortByDesc(function($horse)
        {
            return $horse->statuses()->count();
        });

        return $horses->take(3);
    }

    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function findMostPopularHorses()
    {
        $horses = $this->horse->get()->sortByDesc(function($horse)
        {
            return $horse->followers()->count();
        });

        return $horses->take(3);
    }

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function latestHorse()
    {
        $horses = $this->horse->get()->sortByDesc(function($horse)
        {
            return $horse->userTeams()->count();
        });

        return $horses->take(20);
    }
}
