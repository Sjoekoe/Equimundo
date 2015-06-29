<?php
namespace HorseStories\Models\Pedigrees;

use HorseStories\Models\Horses\Horse;

class PedigreeRepository
{
    /**
     * @var \HorseStories\Models\Pedigrees\Pedigree
     */
    private $pedigree;

    /**
     * @param \HorseStories\Models\Pedigrees\Pedigree $pedigree
     */
    public function __construct(Pedigree $pedigree)
    {
        $this->pedigree = $pedigree;
    }

    /**
     * @param int $id
     * @return \HorseStories\Models\Pedigrees\Pedigree
     */
    public function findById($id)
    {
        return $this->pedigree->findOrFail($id);
    }

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param int $type
     * @return \HorseStories\Models\Pedigrees\Pedigree|null
     */
    public function findExistingPedigree(Horse $horse, $type)
    {
        return $this->pedigree->where('horse_id', $horse->id)->where('type', $type)->first();
    }
}
