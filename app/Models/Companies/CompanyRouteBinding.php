<?php
namespace EQM\Models\Companies;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class CompanyRouteBinding extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Companies\CompanyRepository
     */
    private $companies;

    public function __construct(CompanyRepository $companies)
    {
        $this->companies = $companies;
    }

    /**
     * @param int|string $slug
     * @return mixed
     */
    public function find($slug)
    {
        return $this->companies->findBySlug($slug);
    }
}
