<?php
namespace EQM\Models\Horses;

use DB;
use DateTime;
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
        return $this->horse->where('slug', $slug)->whereNotNull('user_id')->firstOrFail();
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
        $horse->life_number = $values['life_number'];
        $horse->color = $values['color'];
        $horse->date_of_birth = DateTime::createFromFormat('d/m/Y', $values['date_of_birth']);
        $horse->height = $values['height'];

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
        $horse->gender = $values['gender'];
        $horse->breed = $values['breed'];
        $horse->height = $values['height'];
        $horse->color = $values['color'];
        $horse->date_of_birth = DateTime::createFromFormat('d/m/Y', $values['date_of_birth']);
        $horse->life_number = $values['life_number'];

        $horse->save();

        return $horse;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Horses\Horse[]
     */
    public function findForUser(User $user)
    {
        return DB::table('horses')
            ->select('horses.id', 'horses.name')
            ->join('horse_team', 'horses.id', '=', 'horse_team.horse_id')
            ->where('horse_team.user_id', $user->id)
            ->get();
    }
}
