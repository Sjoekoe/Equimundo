<?php
namespace EQM\Models\Horses;

interface Horse
{
    const FEMALE = 2;

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function slug();

    /**
     * @return int
     */
    public function gender();

    /**
     * @return int
     */
    public function breed();

    /**
     * @return string
     */
    public function height();

    /**
     * @return \Carbon\Carbon
     */
    public function dateOfBirth();

    /**
     * @return int
     */
    public function color();

    /**
     * @return string
     */
    public function lifeNumber();

    /**
     * @return \EQM\Models\HorseTeams\HorseTeam[]
     */
    public function userTeams();

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function users();

    /**
     * @return bool
     */
    public function hasOwner();

    /**
     * @return \EQM\Models\Statuses\Status[]
     */
    public function statuses();

    /**
     * @return \EQM\Models\Pictures\Picture[]
     */
    public function pictures();

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function followers();

    /**
     * @return \EQM\Models\Palmares\Palmares[]
     */
    public function palmares();

    /**
     * @return \EQM\Models\Pedigrees\Pedigree[]
     */
    public function pedigree();

    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function family();

    /**
     * @return \EQM\Models\Disciplines\Discipline[]
     */
    public function disciplines();

    /**
     * @return \EQM\Models\Albums\Album[]
     */
    public function albums();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function father();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function mother();

    /**
     * @return bool
     */
    public function hasFather();

    /**
     * @return bool
     */
    public function hasMother();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function fathersFather();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function fathersMother();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function mothersFather();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function mothersMother();

    /**
     * @return \EQM\Models\Pictures\Picture
     */
    public function getProfilePicture();

    /**
     * @return \Carbon\Carbon
     */
    public function getBirthDay();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function sons();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function daughters();

    /**
     * @param int $disciplineId
     * @return bool
     */
    public function performsDiscipline($disciplineId);

    /**
     * @return bool
     */
    public function isFemale();

    /**
     * @param int $type
     * @return \EQM\Models\Albums\Album
     */
    public function getStandardAlbum($type);
}
