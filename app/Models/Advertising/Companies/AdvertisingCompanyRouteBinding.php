<?php
namespace EQM\Models\Advertising\Companies;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class AdvertisingCompanyRouteBinding extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Advertising\Companies\AdvertisingCompanyRepository
     */
    private $advertisingCompanies;

    public function __construct(AdvertisingCompanyRepository $advertisingCompanies)
    {
        $this->advertisingCompanies = $advertisingCompanies;
    }

    /**
     * @param int|string $slug
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany|null
     */
    public function find($slug)
    {
        return $this->advertisingCompanies->findById($slug);
    }
}
