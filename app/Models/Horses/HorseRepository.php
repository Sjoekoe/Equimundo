<?php
namespace EQM\Models\Horses;

use Carbon\Carbon;
use EQM\Models\Users\User;

interface HorseRepository
{
    /**
     * @param array $values
     * @param bool $pedigree
     * @return \EQM\Models\Horses\Horse
     */
    public function create(array $values = [], $pedigree = false);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     * @return \EQM\Models\Horses\Horse
     */
    public function update(Horse $horse, array $values = []);

    /**
     * @param int $id
     * @return \EQM\Models\Horses\Horse
     */
    public function findById($id);

    /**
     * @param string $lifeNumber
     * @return \EQM\Models\Horses\Horse
     */
    public function findByLifeNumber($lifeNumber);

    /**
     * @param string $slug
     * @return \EQM\Models\Horses\Horse
     */
    public function findBySlug($slug);

    /**
     * @param string $slug
     * @return int
     */
    public function findSlugCounts($slug);

    /**
     * @param string $value
     * @return \EQM\Models\Horses\Horse[]
     */
    public function search($value);

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Horses\Horse[]
     */
    public function findForUser(User $user);

    /**
     * @return int
     */
    public function count();

    /**
     * @param int $limit
     * @return \Eqm\Models\Horses\Horse[]
     */
    public function paginated($limit = 10);

    /**
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @return int
     */
    public function findCountByDate(Carbon $start, Carbon $end);

    /**
     * @param \Carbon\Carbon $date
     * @return int
     */
    public function findCreatedHorsesBeforeDate(Carbon $date);

    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function findMostActiveHorses();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function findMostPopularHorses();
}
