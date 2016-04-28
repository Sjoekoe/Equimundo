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

            case $type == Follower::ID:
                return $this->createFollower($user, $company);
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

    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Companies\Company $company
     * @return \EQM\Models\Companies\Users\CompanyUser
     */
    private function createFollower(User $user, Company $company)
    {
        $companyUser = new EloquentFollower();

        return $this->make($companyUser, $user, $company, false);
    }

    public function findByCompanyPaginated(Company $company, $limit = 10)
    {
        return $this->companyUser->where('company_id', $company->id())->latest()->paginate($limit);
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Companies\Users\CompanyUser
     */
    public function findByCompanyAndUser(Company $company, User $user)
    {
        return $this->companyUser
            ->where('company_id', $company->id())
            ->where('user_id', $user->id())
            ->first();
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param \EQM\Models\Users\User $user
     */
    public function deleteByCompanyAndUser(Company $company, User $user)
    {
        $companyUser = $this->findByCompanyAndUser($company, $user);
        
        $companyUser->delete();
    }
}
