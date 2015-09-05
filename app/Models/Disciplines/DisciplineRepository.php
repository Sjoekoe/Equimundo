<?php
namespace EQM\Models\Disciplines;

interface DisciplineRepository
{
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
