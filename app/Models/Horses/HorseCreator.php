<?php 
namespace HorseStories\Models\Horses;
  
use HorseStories\Models\Users\User;

class HorseCreator
{
    public function create(User $user, $values = [])
    {
        $horse = new Horse();

        $horse->name = $values['name'];
        $horse->user_id = $user->id;
        $horse->gender = $values['gender'];
        $horse->breed = $values['breed'];
        $horse->life_number = $values['life_number'];
        $horse->color = $values['color'];
        $horse->date_of_birth = $values['date_of_birth'];
        $horse->height = $values['height'];

        $horse->save();

        return $horse;
    }
}