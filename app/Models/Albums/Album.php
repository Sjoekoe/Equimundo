<?php
namespace EQM\Models\Albums;

interface Album
{
    const PROFILEPICTURES = 1;
    const COVERPICTURES = 2;
    const TIMELINEPICTURES = 3;

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function name();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse();

    /**
     * @return string
     */
    public function description();

    /**
     * @return int
     */
    public function type();

    /**
     * @return \EQM\Models\Pictures\Picture[]
     */
    public function pictures();

    public function setProfileAlbum();

    public function setCoverAlbum();

    public function setTimeLineAlbum();
}
