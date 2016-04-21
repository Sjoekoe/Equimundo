<?php
namespace EQM\Models\Companies;

use EQM\Models\Users\User;

class CompanyPolicy
{
    public function authorize(User $user, Company $company)
    {
        return $user->isCompanyAdmin($company);
    }
}
