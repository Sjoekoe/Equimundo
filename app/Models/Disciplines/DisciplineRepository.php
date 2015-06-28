<?php
namespace HorseStories\Models\Disciplines;

class DisciplineRepository
{
    /**
     * @var \HorseStories\Models\Disciplines\Discipline
     */
    private $discipline;

    /**
     * @param \HorseStories\Models\Disciplines\Discipline $discipline
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
