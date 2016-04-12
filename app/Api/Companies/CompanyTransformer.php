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

    protected $availableIncludes = [
        'userRelation'
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
            'email' => $company->email(),
            'about' => nl2br($company->about()),
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

    /**
     * @param \EQM\Models\Companies\Company $company
     * @return \League\Fractal\Resource\Item
     */
    public function includeUserRelation(Company $company)
    {
        return $this->collection($company->users(), new CompanyUserTransformer());
    }
}
