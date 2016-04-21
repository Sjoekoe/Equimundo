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
        $geocoded = $values['street'] . ' ' . $values['city'] . ' ' . $values['zip'];
        $prepAddr = str_replace(' ', '+', $geocoded);
        $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');

        $output = json_decode($geocode);

        $lat = $output->results[0]->geometry->location->lat;
        $long = $output->results[0]->geometry->location->lng;

        $values['latitude'] = $lat;
        $values['longitude'] = $long;

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
