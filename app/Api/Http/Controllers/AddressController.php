<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Addresses\AddressTransformer;
use EQM\Api\Addresses\Requests\AddressRequest;
use EQM\Api\Http\Controller;
use EQM\Models\Addresses\AddressRepository;

class AddressController extends Controller
{
    /**
     * @var \EQM\Models\Addresses\AddressRepository
     */
    private $addresses;

    public function __construct(AddressRepository $addresses)
    {
        $this->addresses = $addresses;
    }

    public function create(AddressRequest $request)
    {
        $geocoded = $request->get('street') . ' ' . $request->get('zip');
        $prepAddr = str_replace(' ', '+', $geocoded);
        $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');

        $output = json_decode($geocode);

        $lat = $output->results[0]->geometry->location->lat;
        $long = $output->results[0]->geometry->location->lng;

        $values = $request->all();
        $values['latitude'] = $lat;
        $values['longitude'] = $long;

        $address = $this->addresses->create($values);

        return $this->response()->item($address, new AddressTransformer());
    }
}
