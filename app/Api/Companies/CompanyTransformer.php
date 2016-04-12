<?php
namespace EQM\Api\Companies;

use EQM\Api\Addresses\AddressTransformer;
use EQM\Models\Companies\Company;
use League\Fractal\TransformerAbstract;

class CompanyTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'addressRelation',
    ];

    /**
     * @param \EQM\Models\Companies\Company $company
     * @return array
     */
    public function transform(Company $company)
    {
        return [
            'id' => $company->id(),
            'name' => $company->name(),
            'slug' => $company->slug(),
            'website' => $company->website(),
            'telephone' => $company->telephone(),
            'about' => $company->about(),
        ];
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     * @return \League\Fractal\Resource\Item
     */
    public function includeAddressRelation(Company $company)
    {
        return $this->item($company->address(), new AddressTransformer());
    }
}
