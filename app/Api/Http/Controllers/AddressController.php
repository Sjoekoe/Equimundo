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
        $address = $this->addresses->create($request->all());

        return $this->response()->item($address, new AddressTransformer());
    }
}
