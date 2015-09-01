<?php
namespace EQM\Models\Addresses;

interface Address
{
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
    public function addressLine2();

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
}
