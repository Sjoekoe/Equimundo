<?php
namespace EQM\Models\Pedigrees;

use EQM\Models\Horses\Horse;

class PedigreeRepository
{
    /**
     * @var \EQM\Models\Pedigrees\Pedigree
     */
    private $pedigree;

    /**
     * @param \EQM\Models\Pedigrees\Pedigree $pedigree
     */
    public function __construct(Pedigree $pedigree)
    {
        $this->pedigree = $pedigree;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function findById($id)
    {
        return $this->pedigree->findOrFail($id);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param int $type
     * @return \EQM\Models\Pedigrees\Pedigree|null
     */
    public function findExistingPedigree(Horse $horse, $type)
    {
        return $this->pedigree->where('horse_id', $horse->id())->where('type', $type)->first();
    }
}
