<?php
namespace EQM\Models\Pedigrees;

use EQM\Models\Horses\Horse;

class PedigreeConnector
{
    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param int $type
     * @return int
     */
    public function getConnection(Horse $horse, $type)
    {
        $female = $horse->isFemale();

        switch ($type) {
            case Pedigree::MOTHER:
                if ($female) {
                    return Pedigree::DAUGHTER;
                }

                return Pedigree::SON;

            case Pedigree::FATHER:
                if ($female) {
                    return Pedigree::DAUGHTER;
                }

                return Pedigree::SON;

            case Pedigree::SON:
                if ($female) {
                    return Pedigree::MOTHER;
                }

                return Pedigree::FATHER;

            case Pedigree::DAUGHTER:
                if ($female) {
                    return Pedigree::MOTHER;
                }

                return Pedigree::FATHER;
        }
    }

    /**
     * @param int $type
     * @return int
     */
    public function getGender($type)
    {
        if ($type == Pedigree::MOTHER || $type == Pedigree::DAUGHTER) {
            return Horse::MARE;
        }

        return Horse::STALLION;
    }
}
