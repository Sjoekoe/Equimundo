<?php
namespace HorseStories\Models\Horses;

use DateTime;
use HorseStories\Models\Disciplines\DisciplineRepository;

class HorseUpdater
{
    /**
     * @var \HorseStories\Models\Disciplines\DisciplineRepository
     */
    private $disciplines;

    /**
     * @param \HorseStories\Models\Disciplines\DisciplineRepository $disciplines
     */
    public function __construct(DisciplineRepository $disciplines)
    {
        $this->disciplines = $disciplines;
    }

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param array $values
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

        foreach ($horse->disciplines as $initialDiscipline) {
            $initialDisciplines[$initialDiscipline->id] = $initialDiscipline->discipline;
        }

        foreach($values['disciplines'] as $discipline) {
            $horse->disciplines()->updateOrCreate(['discipline' => $discipline, 'horse_id' => $horse->id]);
        }

        $unwantedDisciplines = array_diff($initialDisciplines, $values['disciplines']);

        foreach($unwantedDisciplines as $key => $values) {
            $this->disciplines->removeById($key);
        }

        $horse->save();
    }
}
