<?php
namespace EQM\Models\Advertising\Companies;

interface AdvertisingCompany
{
    const TABLE = 'adv_companies';

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
    public function tax();

    /**
     * @return string
     */
    public function telephone();

    /**
     * @return string
     */
    public function email();

    /**
     * @return \EQM\Models\Advertising\Advertisements\Advertisement[]
     */
    public function advertisements();

    /**
     * @return \EQM\Models\Addresses\Address
     */
    public function address();

    /**
     * @return \EQM\Models\Advertising\Contacts\AdvertisingContact
     */
    public function contact();

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();
}
