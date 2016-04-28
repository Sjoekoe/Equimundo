<?php
namespace EQM\Http\Controllers\Admin;

use Carbon\Carbon;
use EQM\Http\Controllers\Controller;
use EQM\Models\Companies\CompanyRepository;

class GroupController extends Controller
{
    /**
     * @var \EQM\Models\Companies\CompanyRepository
     */
    private $companies;

    public function __construct(CompanyRepository $companies)
    {
        $this->companies = $companies;
    }

    public function index()
    {
        $companies = $this->companies->paginated(30);
        $companiesRegistered = $this->collectCompanyData();
        $companyGrowth = $this->companyGrowth();
        
        return view('admin.companies.index', compact('companies', 'companiesRegistered', 'companyGrowth'));
    }

    private function collectCompanyData()
    {
        $month = 30;
        $result = [];

        for ($i = $month; $i >= 0; $i--) {
            $date = Carbon::now()->subDay($i);
            $start = Carbon::now()->subDay($i)->startOfDay();
            $end = Carbon::now()->subDay($i)->endOfDay();
            $count = $this->companies->findCountByDate($start, $end);

            $result[] = [
                'date' => $date->format('Y-m-d'),
                'companies' => $count
            ];
        }

        return $result;
    }

    private function companyGrowth()
    {
        $month = 30;
        $result = [];

        for ($i = $month; $i >= 0; $i--) {
            $date = Carbon::now()->subDay($i);
            $end = Carbon::now()->subDay($i)->endOfDay();
            $count = $this->companies->findRegisteredUsersBeforeDate($end);

            $result[] = [
                'date' => $date->format('Y-m-d'),
                'companies' => $count
            ];
        }

        return $result;
    }
}
