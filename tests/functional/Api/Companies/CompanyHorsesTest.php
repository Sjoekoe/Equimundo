<?php
namespace functional\Api\Companies;

use DB;
use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Companies\Horses\CompanyHorse;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyHorsesTest extends \TestCase
{
    use DefaultIncludes, DatabaseTransactions;

    /** @test */
    function it_can_get_all_horses_for_a_company()
    {
        $horse = $this->createHorse();
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);

        $companyHorse = $this->createCompanyHorse([
            'horse_id' => $horse->id(),
            'company_id' => $company->id(),
        ]);

        $this->get('/api/companies/' . $company->slug() . '/horses')
            ->seeJsonEquals([
                'data' => [
                    $this->includedCompanyHorse($companyHorse),
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
    function it_can_create_a_company_horse()
    {
        $horse = $this->createHorse();
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);

        $this->post('/api/companies/' . $company->slug() . '/horses', [
            'horse_id' => $horse->id(),
        ])->seeJsonEquals([
            'data' => [
                'id' => DB::table(CompanyHorse::TABLE)->first()->id,
                'companyRelation' => [
                    'data' => $this->includedCompany($company),
                ],
                'horseRelation' => [
                    'data' => $this->includedHorse($horse),
                ],
            ],
        ]);
    }

    /** @test */
    function it_can_show_a_company_horse()
    {
        $horse = $this->createHorse();
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);

        $companyHorse = $this->createCompanyHorse([
            'horse_id' => $horse->id(),
            'company_id' => $company->id(),
        ]);

        $this->get('/api/companies/' . $company->slug() . '/horses/' . $horse->id())
            ->seeJsonEquals([
                'data' => $this->includedCompanyHorse($companyHorse),
            ]);
    }

    /** @test */
    function it_can_delete_a_company_horse()
    {
        $horse = $this->createHorse();
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);

        $companyHorse = $this->createCompanyHorse([
            'horse_id' => $horse->id(),
            'company_id' => $company->id(),
        ]);

        $this->seeInDatabase(CompanyHorse::TABLE, [
            'id' => $companyHorse->id(),
        ]);

        $this->delete('/api/companies/' . $company->slug() . '/horses/' . $horse->id())
            ->assertResponseStatus(204);

        $this->missingFromDatabase(CompanyHorse::TABLE, [
            'id' => $companyHorse->id(),
        ]);
    }
}
