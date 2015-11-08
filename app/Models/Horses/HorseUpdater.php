<?php
namespace EQM\Models\Horses;

use EQM\Models\Disciplines\DisciplineResolver;

class HorseUpdater
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Disciplines\DisciplineResolver
     */
    private $disciplineResolver;

    /**
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Disciplines\DisciplineResolver $disciplineResolver
     */
    public function __construct(HorseRepository $horses, DisciplineResolver $disciplineResolver)
    {
        $this->horses = $horses;
        $this->disciplineResolver = $disciplineResolver;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     * @return \EQM\Models\Horses\Horse
     */
    public function update(Horse $horse, array $values)
    {
        $horse = $this->horses->update($horse, $values);

        $this->disciplineResolver->resolve($horse, $values);

        return $horse;
    }
}
