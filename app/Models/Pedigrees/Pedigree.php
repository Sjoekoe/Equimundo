<?php
namespace EQM\Models\Pedigrees;

interface Pedigree
{
    const TABLE = 'pedigrees';
    const FATHER = 1;
    const MOTHER = 2;
    const SON = 3;
    const DAUGHTER = 4;
    const FATHERSMOTHER = 6;
    const MOTHERSMOTHER = 8;

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse();

    /**
     * @return int
     */
    public function type();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function originalHorse();

    /**
     * @return bool
     */
    public function hasFather();

    /**
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function father();
}
