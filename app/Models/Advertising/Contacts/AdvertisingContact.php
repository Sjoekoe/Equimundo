<?php
namespace EQM\Models\Advertising\Contacts;

interface AdvertisingContact
{
    const TABLE = 'adv_contacts';

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function firstName();

    /**
     * @return string
     */
    public function lastName();

    /**
     * @return string
     */
    public function email();

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();
}
