<?php
namespace EQM\Models\Addresses;

interface AddressRepository
{
    /**
     * @param array $values
     * @return \EQM\Models\Addresses\EloquentAddress
     */
    public function create(array $values);

    /**
     * @param \EQM\Models\Addresses\Address $address
     * @param array $values
     * @return \EQM\Models\Addresses\Address
     */
    public function update(Address $address, array $values);
}
