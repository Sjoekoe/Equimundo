<?php
namespace functional\Api\Companies;

use EQM\Core\Testing\DefaultIncludes;

class CompanyUsersTest extends \TestCase
{
    use DefaultIncludes;

    /** @test */
    function it_can_get_all_users_for_a_company()
    {
        $user = $this->createUser();
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);
        $companyUser = $this->createCompanyUser([
            'company_id' => $company->id(),
            'user_id' => $user->id(),
        ]);

        $this->get('/api/companies/' . $company->slug() . '/users')
            ->seeJsonEquals([
                'data' => [
                    $this->includedCompanyUser($companyUser),
                ],
                'meta' => [
                    'pagination' => [
                        'count' => 1,
                        'current_page' => 1,
                        'links' => [],
                        'per_page' => 10,
                        'total' => 1,
                        'total_pages' => 1,
                    ],
                ]
            ]);
    }
}
