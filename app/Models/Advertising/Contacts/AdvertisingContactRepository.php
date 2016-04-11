<?php
namespace EQM\Models\Advertising\Contacts;

interface AdvertisingContactRepository
{
    /**
     * @param array $values
     * @return \EQM\Models\Advertising\Contacts\AdvertisingContact
     */
    public function create(array $values);

    /**
     * @param \EQM\Models\Advertising\Contacts\AdvertisingContact $advertisingContact
     * @param array $values
     * @return \EQM\Models\Advertising\Contacts\AdvertisingContact
     */
    public function update(AdvertisingContact $advertisingContact, array $values);

    /**
     * @param \EQM\Models\Advertising\Contacts\AdvertisingContact $advertisingContact
     */
    public function delete(AdvertisingContact $advertisingContact);

    /**
     * @param $id
     * @return \EQM\Models\Advertising\Contacts\AdvertisingContact|null
     */
    public function findById($id);

    public function findAllPaginated($limit = 10);
}
