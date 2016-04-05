<?php
namespace EQM\Models\Advertising\Advertisements;

interface Advertisement
{
    const TABLE = 'adv_advertisements';

    /**
     * @return int
     */
    public function id();

    /**
     * @return \Carbon\Carbon
     */
    public function start();

    /**
     * @return \Carbon\Carbon
     */
    public function end();

    /**
     * @return int
     */
    public function type();

    /**
     * @return bool
     */
    public function paid();

    /**
     * @return int
     */
    public function amount();

    /**
     * @return int
     */
    public function clicks();

    /**
     * @return int
     */
    public function views();

    /**
     * @return string
     */
    public function website();

    /**
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany
     */
    public function company();

    /**
     * @return \EQM\Models\Pictures\Picture
     */
    public function picture();

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();
}
