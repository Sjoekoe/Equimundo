<?php
namespace EQM\Models\Pedigrees;

use EQM\Models\Horses\Horse;

class EloquentPedigreeRepository implements PedigreeRepository
{
    /**
     * @var \EQM\Models\Pedigrees\EloquentPedigree
     */
    private $pedigree;

    /**
     * @param \EQM\Models\Pedigrees\EloquentPedigree $pedigree
     */
    public function __construct(EloquentPedigree $pedigree)
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


    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Models\Horses\Horse $family
     * @param int $type
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function create(Horse $horse, Horse $family, $type)
    {
        $pedigree = new EloquentPedigree();

        $pedigree->horse_id = $horse->id();
        $pedigree->type = $type;
        $pedigree->family_id = $family->id();

        $pedigree->save();

        return $pedigree;
    }

    /**
     * @param \EQM\Models\Pedigrees\Pedigree $pedigree
     * @param array $values
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function update(Pedigree $pedigree, array $values)
    {
        $pedigree->type = $values['type'];
        $pedigree->family_name = $values['name'];
        $pedigree->family_life_number = $values['life_number'];
        $pedigree->color = $values['color'];
        $pedigree->breed = $values['breed'];
        $pedigree->height = $values['height'];

        if ($values['date_of_birth']) {
            $pedigree->date_of_birth = new DateTime($values['date_of_birth']);
        }

        $pedigree->save();

        return $pedigree;
    }

    /**
     * @param \EQM\Models\Pedigrees\Pedigree $pedigree
     */
    public function delete(Pedigree $pedigree)
    {
        $pedigree->delete();
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->pedigree->all());
    }
}
