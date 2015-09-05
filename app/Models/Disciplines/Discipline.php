<?php
namespace EQM\Models\Disciplines;

interface Discipline
{
    /**
     * @return int
     */
    public function id();

    /**
     * @return int
     */
    public function discipline();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse();

    /**
     * @return \DateTime
     */
    public function createdAt();

    /**
     * @return \DateTime
     */
    public function updatedAt();
}
