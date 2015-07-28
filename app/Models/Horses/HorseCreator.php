<?php
namespace EQM\Models\Horses;

use DateTime;
use EQM\Core\Slugs\SlugCreator;
use EQM\Models\Users\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Str;

class HorseCreator
{
    /**
     * @var \EQM\Core\Slugs\SlugCreator
     */
    private $slugCreator;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @param \EQM\Core\Slugs\SlugCreator $slugCreator
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct(SlugCreator $slugCreator, AuthManager $auth)
    {
        $this->slugCreator = $slugCreator;
        $this->auth = $auth;
    }

    /**
     * @param array $values
     * @param bool $pedigree
     * @return \EQM\Models\Horses\Horse
     */
    public function create($values = [], $pedigree = false)
    {
        $horse = new Horse();

        $horse->name = $values['name'];

        if (! $pedigree) {
            $horse->user_id = $this->auth->user()->id;
        }

        $horse->gender = $values['gender'];
        $horse->breed = $values['breed'];
        $horse->life_number = $values['life_number'];
        $horse->color = $values['color'];
        $horse->date_of_birth = DateTime::createFromFormat('d/m/Y', $values['date_of_birth']);
        $horse->height = $values['height'];
        $horse->slug = $this->slugCreator->createForHorse($values['name']);

        $horse->save();

        if (array_key_exists('disciplines', $values)) {
            foreach($values['disciplines'] as $discipline) {
                $horse->disciplines()->updateOrCreate(['discipline' => $discipline, 'horse_id' => $horse->id]);
            }
        }

        return $horse;
    }
}
