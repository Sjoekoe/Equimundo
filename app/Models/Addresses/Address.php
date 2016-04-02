<?php
namespace EQM\Models\Addresses;

interface Address
{
    const TABLE = 'addresses';
    
    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function street();

    /**
     * @return string
     */
    public function city();

    /**
     * @return string
     */
    public function state();

    /**
     * @return string
     */
    public function zip();

    /**
     * @return string
     */
    public function country();

    /**
     * @return string
     */
    public function longitude();

    /**
     * @return string
     */
    public function latitude();
}
