<?php
namespace EQM\Models\Horses;

use DateTime;
use EQM\Models\Disciplines\EloquentDisciplineRepository;

class HorseUpdater
{
    /**
     * @var \EQM\Models\Disciplines\EloquentDisciplineRepository
     */
    private $disciplines;

    /**
     * @param \EQM\Models\Disciplines\EloquentDisciplineRepository $disciplines
     */
    public function __construct(EloquentDisciplineRepository $disciplines)
    {
        $this->disciplines = $disciplines;
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

        $initialDisciplines = [];
        $unwantedDisciplines = [];

        foreach ($horse->disciplines as $initialDiscipline) {
            $initialDisciplines[$initialDiscipline->id] = $initialDiscipline->discipline;
        }

        if (array_key_exists('disciplines', $values)) {
            foreach($values['disciplines'] as $discipline) {
                $horse->disciplines()->updateOrCreate(['discipline' => $discipline, 'horse_id' => $horse->id]);
            }

            $unwantedDisciplines = array_diff($initialDisciplines, $values['disciplines']);
        }


        foreach ($unwantedDisciplines as $key => $values) {
            $this->disciplines->removeById($key);
        }

        $horse->save();

        return $horse;
    }
}
