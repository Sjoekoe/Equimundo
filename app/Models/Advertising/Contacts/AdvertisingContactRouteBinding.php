<?php
namespace EQM\Models\Advertising\Contacts;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class AdvertisingContactRouteBinding extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Advertising\Contacts\AdvertisingContactRepository
     */
    private $advertisingContacts;

    public function __construct(AdvertisingContactRepository $advertisingContacts)
    {
        $this->advertisingContacts = $advertisingContacts;
    }

    /**
     * @param int|string $id
     * @return \EQM\Models\Advertising\Contacts\AdvertisingContact|null
     */
    public function find($id)
    {
        return $this->advertisingContacts->findById($id);
    }
}
