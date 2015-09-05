<?php
namespace EQM\Models\Disciplines;

class EloquentDisciplineRepository implements DisciplineRepository
{
    /**
     * @var \EQM\Models\Disciplines\EloquentDiscipline
     */
    private $discipline;

    /**
     * @param \EQM\Models\Disciplines\EloquentDiscipline $discipline
     */
    public function __construct(EloquentDiscipline $discipline)
    {
        $this->discipline = $discipline;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Disciplines\Discipline
     */
    public function findById($id)
    {
        return $this->discipline->where('id', $id)->firstOrFail();
    }

    /**
     * @param int $id
     */
    public function removeById($id)
    {
        $discipline = $this->findById($id);

        $discipline->delete();
    }
}
