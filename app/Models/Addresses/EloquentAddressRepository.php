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

    /**
     * @param \EQM\Models\Addresses\Address $address
     * @param array $values
     * @return \EQM\Models\Addresses\Address
     */
    public function update(Address $address, array $values)
    {
        $geocoded = $values['street'] . ' ' . $values['city'] . ' ' . $values['zip'];
        $prepAddr = str_replace(' ', '+', $geocoded);
        $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');

        $output = json_decode($geocode);

        $lat = $output->results[0]->geometry->location->lat;
        $long = $output->results[0]->geometry->location->lng;

        $values['latitude'] = $lat;
        $values['longitude'] = $long;

        if ($address = $this->findByLatLong($values['latitude'], $values['longitude'])) {
            return $address;
        }

        $address = $this->create($values);

        return $address;
    }

    /**
     * @param string $latitude
     * @param string $longitude
     * @return \EQM\Models\Addresses\Address|null
     */
    private function findByLatLong($latitude, $longitude)
    {
        return $this->address
            ->where('latitude', $latitude)
            ->where('longitude', $longitude)
            ->first();
    }
}
