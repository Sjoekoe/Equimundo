<?php
namespace EQM\Models\Pedigrees;

use EQM\Models\Horses\Horse;

interface PedigreeRepository
{
    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Models\Horses\Horse $family
     * @param int $type
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function create(Horse $horse, Horse $family, $type);

    /**
     * @param \EQM\Models\Pedigrees\Pedigree $pedigree
     * @param array $values
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function update(Pedigree $pedigree, array $values);

    /**
     * @param \EQM\Models\Pedigrees\Pedigree $pedigree
     */
    public function delete(Pedigree $pedigree);

    /**
     * @param int $id
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function findById($id);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param int $type
     * @return \EQM\Models\Pedigrees\Pedigree|null
     */
    public function findExistingPedigree(Horse $horse, $type);
}
