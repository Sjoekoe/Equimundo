<?php
namespace EQM\Models\Companies\Users;

use EQM\Models\Companies\Company;
use EQM\Models\Users\User;

class EloquentCompanyUserRepository implements CompanyUserRepository
{
    /**
     * @var \EQM\Models\Companies\Users\EloquentCompanyUser
     */
    private $companyUser;

    public function __construct(EloquentCompanyUser $companyUser)
    {
        $this->companyUser = $companyUser;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Companies\Company $company
     * @param int $type
     * @param bool $isAdmin
     * @return \EQM\Models\Companies\Users\CompanyUser
     */
    public function create(User $user, Company $company, $type, $isAdmin = false)
    {
        switch ($type) {
            case $type == TeamMember::ID:
                return $this->createTeamMember($user, $company, $isAdmin);
        }
    }

    /**
     * @param \EQM\Models\Companies\Users\CompanyUser $companyUser
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Companies\Company $company
     * @param bool $isAdmin
     * @return \EQM\Models\Companies\Users\CompanyUser
     */
    private function make(CompanyUser $companyUser, User $user, Company $company, $isAdmin = false)
    {
        $companyUser->user_id = $user->id();
        $companyUser->company_id = $company->id();
        $companyUser->is_admin = $isAdmin;

        $companyUser->save();

        return $companyUser;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Companies\Company $company
     * @param bool $isAdmin
     * @return \EQM\Models\Companies\Users\CompanyUser
     */
    private function createTeamMember(User $user, Company $company, $isAdmin = false)
    {
        $companyUser = new EloquentTeamMember();

        return $this->make($companyUser, $user, $company, $isAdmin);
    }
}
