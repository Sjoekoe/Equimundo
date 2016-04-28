<?php
namespace functional\Api\Companies;

use DB;
use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Companies\Users\CompanyUser;
use EQM\Models\Companies\Users\Follower;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyUsersTest extends \TestCase
{
    use DefaultIncludes, DatabaseTransactions;

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

    /** @test */
    function it_can_create_a_company_user_and_not_make_a_follower_admin()
    {
        $user = $this->loginAsUser();
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);

        $this->post('/api/companies/' . $company->slug() . '/users', [
            'is_admin' => true,
            'type' => Follower::ID,
        ])->seeJsonEquals([
            'data' => [
                'id' => DB::table(CompanyUser::TABLE)->first()->id,
                'is_admin' => false,
                'userRelation' => $this->includedUser($user),
                'companyRelation' => [
                    'data' => $this->includedCompany($company, [
                        'is_followed_by_user' => true,
                    ])
                ],
            ]
        ]);
    }

    /** @test */
    function it_can_show_a_company_user()
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

        $this->get('/api/companies/' . $company->slug() . '/users/' . $user->id())
            ->seeJsonEquals([
                'data' => $this->includedCompanyUser($companyUser),
            ]);
    }

    /** @test */
    function it_can_delete_a_company_user()
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

        $this->seeInDatabase(CompanyUser::TABLE, [
            'id' => $companyUser->id(),
        ]);

        $this->delete('/api/companies/' . $company->slug() . '/users/' . $user->id())
            ->assertResponseStatus(204);

        $this->missingFromDatabase(CompanyUser::TABLE, [
            'id' => $companyUser->id(),
        ]);
    }
}
