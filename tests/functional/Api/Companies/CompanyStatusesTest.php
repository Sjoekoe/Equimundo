<?php
namespace functional\Api\Companies;

use Carbon\Carbon;
use DB;
use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Statuses\Status;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyStatusesTest extends \TestCase
{
    use DefaultIncludes, DatabaseTransactions;

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

    /** @test */
    function it_can_create_a_company_status()
    {
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);

        $now = Carbon::now();

        $this->post('/api/companies/' . $company->slug() . '/statuses', [
            'body' => 'Test Status',
        ])->seeJsonEquals([
            'data' => [
                'id' => DB::table(Status::TABLE)->first()->id,
                'body' => 'Test Status',
                'created_at' => $now->toIso8601String(),
                'like_count' => 0,
                'prefix' => null,
                'liked_by_user' => false,
                'can_delete_status' => false,
                'picture' => null,
                'is_horse_status' => false,
                'comments' => [
                    'data' => [],
                ],
                'poster' => [
                    'data' => $this->includedCompany($company),
                ],
            ],
        ]);
    }
}
