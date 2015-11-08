<?php
namespace EQM\Models\Disciplines;

use EQM\Models\Horses\Horse;

interface DisciplineRepository
{
    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param int $discipline
     * @return \EQM\Models\Disciplines\Discipline
     */
    public function create(Horse $horse, $discipline);

    /**
     * @param int $id
     * @return \EQM\Models\Disciplines\Discipline
     */
    public function findById($id);

    /**
     * @param int $id
     */
    public function removeById($id);
}
