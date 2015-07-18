<?php
namespace HorseStories\Models\Pedigrees;

use HorseStories\Models\Horses\Horse;

class PedigreeConnector
{
    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param int $type
     * @return int
     */
    public function getConnection(Horse $horse, $type)
    {
        $female = $horse->isFemale();

        switch ($type) {
            case Pedigree::MOTHER:
                if ($female) {
                    return 4;
                }

                return 3;

            case Pedigree::FATHER:
                if ($female) {
                    return 4;
                }

                return 3;

            case Pedigree::SON:
                if ($female) {
                    return 2;
                }

                return 1;

            case Pedigree::DAUGHTER:
                if ($female) {
                    return 2;
                }

                return 1;
        }
    }

    /**
     * @param int $type
     * @return int
     */
    public function getGender($type)
    {
        if ($type == 2 || $type == 4) {
            return 2;
        }

        return 1;
    }
}
