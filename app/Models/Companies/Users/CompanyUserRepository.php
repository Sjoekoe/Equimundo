<?php
namespace EQM\Models\Companies\Users;

use EQM\Models\Companies\Company;
use EQM\Models\Users\User;

interface CompanyUserRepository
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Companies\Company $company
     * @param int $type
     * @param bool $isAdmin
     * @return \EQM\Models\Companies\Users\CompanyUser
     */
    public function create(User $user, Company $company, $type, $isAdmin = false);
    
    public function findByCompanyPaginated(Company $company, $limit = 10);
}
