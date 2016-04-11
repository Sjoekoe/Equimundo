<?php
namespace EQM\Models\Addresses;

interface AddressRepository
{
    /**
     * @param array $values
     * @return \EQM\Models\Addresses\EloquentAddress
     */
    public function create(array $values);
}
