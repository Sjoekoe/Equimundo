<?php
namespace EQM\Api\Advertising;

use EQM\Api\Addresses\AddressTransformer;
use EQM\Models\Advertising\Companies\AdvertisingCompany;
use League\Fractal\TransformerAbstract;

class AdvertisingCompanyTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'contactRelation',
        'addressRelation',
    ];

    /**
     * @param \EQM\Models\Advertising\Companies\AdvertisingCompany $advertisingCompany
     * @return array
     */
    public function transform(AdvertisingCompany $advertisingCompany)
    {
        return [
            'id' => $advertisingCompany->id(),
            'name' => $advertisingCompany->name(),
            'email' => $advertisingCompany->email(),
            'telephone' => $advertisingCompany->telephone(),
            'tax' => $advertisingCompany->tax(),
        ];
    }

    /**
     * @param \EQM\Models\Advertising\Companies\AdvertisingCompany $advertisingCompany
     * @return \League\Fractal\Resource\Item
     */
    public function includeContactRelation(AdvertisingCompany $advertisingCompany)
    {
        return $this->item($advertisingCompany->contact(), new AdvertisingContactTransformer());
    }

    /**
     * @param \EQM\Models\Advertising\Companies\AdvertisingCompany $advertisingCompany
     * @return \League\Fractal\Resource\Item
     */
    public function includeAddressRelation(AdvertisingCompany $advertisingCompany)
    {
        return $this->item($advertisingCompany->address(), new AddressTransformer());
    }
}
