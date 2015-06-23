<?php
namespace HorseStories\Models\Horses;

use DateTime;

class HorseUpdater
{
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

        $horse->save();
    }
}