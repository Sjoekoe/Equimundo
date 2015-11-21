<?php
namespace EQM\Models\Horses;

use EQM\Core\Files\Uploader;
use EQM\Core\Slugs\SlugCreator;
use EQM\Models\Albums\Album;
use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Disciplines\DisciplineRepository;
use EQM\Models\Disciplines\DisciplineResolver;
use EQM\Models\HorseTeams\HorseTeamRepository;
use EQM\Models\Users\User;
use Illuminate\Events\Dispatcher;

class HorseCreator
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Disciplines\DisciplineRepository
     */
    private $disciplines;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \EQM\Core\Slugs\SlugCreator
     */
    private $slugCreator;

    /**
     * @var \EQM\Models\HorseTeams\HorseTeamRepository
     */
    private $horseTeams;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    private $dispatcher;

    /**
     * @var \EQM\Models\Disciplines\DisciplineResolver
     */
    private $disciplineResolver;

    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    public function __construct(
        HorseRepository $horses,
        DisciplineRepository $disciplines,
        Uploader $uploader,
        SlugCreator $slugCreator,
        HorseTeamRepository $horseTeams,
        Dispatcher $dispatcher,
        DisciplineResolver $disciplineResolver,
        AlbumRepository $albums
    ) {
        $this->horses = $horses;
        $this->disciplines = $disciplines;
        $this->uploader = $uploader;
        $this->slugCreator = $slugCreator;
        $this->horseTeams = $horseTeams;
        $this->dispatcher = $dispatcher;
        $this->disciplineResolver = $disciplineResolver;
        $this->albums = $albums;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @param bool $pedigree
     * @return \EQM\Models\Horses\Horse
     */
    public function create(User $user, $values, $pedigree = false)
    {
        if ($values['life_number'] && $horse = $this->horses->findByLifeNumber($values['life_number'])) {
            $horse = $this->horses->update($horse, $values);

            $this->disciplineResolver->resolve($horse, $values);
        } else {
            $horse = $this->horses->create($values);

            $horse->slug = $this->slugCreator->createForHorse($values['name']);

            if (array_key_exists('disciplines', $values)) {
                $this->disciplineResolver->addDisciplines($horse, $values);
            }
        }

        if (! $pedigree) {
            $this->albums->createStandardAlbums($horse);

            $this->horseTeams->createOwner($user, $horse);
        }


        if (array_key_exists('profile_pic', $values)) {
            $picture = $this->uploader->uploadPicture($values['profile_pic'], $horse, true);

            $picture->addToAlbum($horse->getStandardAlbum(Album::PROFILEPICTURES));
        }

        $horse->save();

        return $horse;
    }
}
