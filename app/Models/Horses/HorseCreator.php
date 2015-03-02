<?php 
namespace HorseStories\Models\Horses;
  
use HorseStories\Core\Slugs\SlugCreator;
use HorseStories\Models\Users\User;
use Illuminate\Support\Str;

class HorseCreator
{
    /**
     * @var \HorseStories\Core\Slugs\SlugCreator
     */
    private $slugCreator;

    /**
     * @param \HorseStories\Core\Slugs\SlugCreator $slugCreator
     */
    public function __construct(SlugCreator $slugCreator)
    {
        $this->slugCreator = $slugCreator;
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     * @param array $values
     * @return \HorseStories\Models\Horses\Horse
     */
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
        $horse->slug = $this->slugCreator->createForHorse($values['name']);

        $horse->save();

        return $horse;
    }
}