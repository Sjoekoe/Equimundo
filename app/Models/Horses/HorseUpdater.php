<?php
namespace HorseStories\Models\Horses;

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
        $horse->date_of_birth = $values['date_of_birth'];
        $horse->life_number = $values['life_number'];

        $horse->save();
    }
}