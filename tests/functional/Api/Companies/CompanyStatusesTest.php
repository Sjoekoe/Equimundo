<?php
namespace functional\Api\Companies;

use EQM\Core\Testing\DefaultIncludes;

class CompanyStatusesTest extends \TestCase
{
    use DefaultIncludes;

    /** @test */
    function it_can_get_all_statuses_for_a_company()
    {
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);
        $companyStatus = $this->createCompanyStatus([
            'company_id' => $company->id(),
        ]);

        $this->get('/api/companies/' . $company->slug() . '/statuses')
            ->seeJsonEquals([
                'data' => [
                    $this->includedCompanyStatus($companyStatus),
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
                ],
            ]);
    }
}
