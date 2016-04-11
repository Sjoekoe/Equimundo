<?php
namespace EQM\Api\Addresses;

use EQM\Models\Addresses\Address;
use League\Fractal\TransformerAbstract;

class AddressTransformer extends TransformerAbstract
{
    /**
     * @param \EQM\Models\Addresses\Address $address
     * @return array
     */
    public function transform(Address $address)
    {
        return [
            'id' => $address->id(),
            'street' => $address->street(),
            'city' => $address->city(),
            'state' => $address->state(),
            'country' => $address->country(),
            'zip' => $address->zip(),
            'latitude' => $address->latitude(),
            'longitude' => $address->longitude(),
        ];
    }
}
