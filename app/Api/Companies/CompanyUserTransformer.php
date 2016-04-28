<?php
namespace EQM\Api\Companies;

use EQM\Api\Users\UserTransformer;
use EQM\Models\Companies\Users\CompanyUser;
use EQM\Models\Companies\Users\TeamMember;
use League\Fractal\TransformerAbstract;

class CompanyUserTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'userRelation',
        'companyRelation',
    ];

    /**
     * @param \EQM\Models\Companies\Users\CompanyUser $companyUser
     * @return array
     */
    public function transform(CompanyUser $companyUser)
    {
        return [
            'id' => $companyUser->id(),
            'is_admin' => (bool) $companyUser instanceof TeamMember ? $companyUser->isAdmin() : false,
        ];
    }

    /**
     * @param \EQM\Models\Companies\Users\CompanyUser $companyUser
     * @return \League\Fractal\Resource\Item
     */
    public function includeUserRelation(CompanyUser $companyUser)
    {
        return $this->item($companyUser->user(), new UserTransformer());
    }

    /**
     * @param \EQM\Models\Companies\Users\CompanyUser $companyUser
     * @return \League\Fractal\Resource\Item
     */
    public function includeCompanyRelation(CompanyUser $companyUser)
    {
        return $this->item($companyUser->company(), new CompanyTransformer());
    }
}
