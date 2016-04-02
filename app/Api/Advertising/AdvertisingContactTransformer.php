<?php
namespace EQM\Api\Advertising;

use EQM\Models\Advertising\Contacts\AdvertisingContact;
use League\Fractal\TransformerAbstract;

class AdvertisingContactTransformer extends TransformerAbstract
{
    /**
     * @param \EQM\Models\Advertising\Contacts\AdvertisingContact $advertisingContact
     * @return array
     */
    public function transform(AdvertisingContact $advertisingContact)
    {
        return [
            'id' => $advertisingContact->id(),
            'first_name' => $advertisingContact->firstName(),
            'last_name' => $advertisingContact->lastName(),
            'email' => $advertisingContact->email(),
            'telephone' => $advertisingContact->telephone(),
        ];
    }
}
