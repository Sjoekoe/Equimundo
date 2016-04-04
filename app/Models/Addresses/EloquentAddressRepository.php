<?php
namespace EQM\Models\Addresses;

class EloquentAddressRepository implements AddressRepository
{
    /**
     * @var \EQM\Models\Addresses\EloquentAddress
     */
    private $address;

    public function __construct(EloquentAddress $address)
    {
        $this->address = $address;
    }

    /**
     * @param array $values
     * @return \EQM\Models\Addresses\EloquentAddress
     */
    public function create(array $values)
    {
        $address = new EloquentAddress([
            'street' => $values['street'],
            'zip' => $values['zip'],
            'city' => $values['city'],
            'state' => $values['state'],
            'country' => $values['country'],
            'latitude' => $values['latitude'],
            'longitude' => $values['longitude'],
        ]);

        $address->save();

        return $address;
    }
}
