<?php
namespace EQM\Models\Disciplines;

use EQM\Models\Horses\Horse;

class DisciplineResolver
{
    /**
     * @var \EQM\Models\Disciplines\DisciplineRepository
     */
    private $disciplines;

    /**
     * @param \EQM\Models\Disciplines\DisciplineRepository $disciplines
     */
    public function __construct(DisciplineRepository $disciplines)
    {
        $this->disciplines = $disciplines;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     */
    public function resolve(Horse $horse, array $values = [])
    {
        $initialDisciplines = [];
        $unwantedDisciplines = [];

        foreach ($horse->disciplines() as $initialDiscipline) {
            $initialDisciplines[$initialDiscipline->id()] = $initialDiscipline->discipline();
        }

        if (array_key_exists('disciplines', $values)) {
            $this->addDisciplines($horse, $values);

            $unwantedDisciplines = array_diff($initialDisciplines, $values['disciplines']);
        } else {
            $this->removeAllDisciplines($horse);
        }

        foreach ($unwantedDisciplines as $key => $values) {
            $this->disciplines->removeById($key);
        }
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     */
    public function addDisciplines(Horse $horse, array $values)
    {
        foreach ($values['disciplines'] as $discipline) {
            $this->disciplines->create($horse, $discipline);
        }
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     */
    private function removeAllDisciplines(Horse $horse)
    {
        foreach ($horse->disciplines() as $discipline) {
            $this->disciplines->removeById($discipline->id());
        }
    }
}
