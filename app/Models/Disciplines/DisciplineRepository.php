<?php
namespace EQM\Models\Disciplines;

class DisciplineRepository
{
    /**
     * @var \EQM\Models\Disciplines\Discipline
     */
    private $discipline;

    /**
     * @param \EQM\Models\Disciplines\Discipline $discipline
     */
    public function __construct(Discipline $discipline)
    {
        $this->discipline = $discipline;
    }

    /**
     * @param int $id
     */
    public function removeById($id)
    {
        $this->discipline->find($id)->delete();
    }
}
