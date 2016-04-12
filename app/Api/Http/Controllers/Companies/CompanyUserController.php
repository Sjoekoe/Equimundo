<?php
namespace EQM\Api\Http\Controllers\Companies;

use EQM\Api\Companies\CompanyUserTransformer;
use EQM\Api\Http\Controller;
use EQM\Models\Companies\Company;
use EQM\Models\Companies\Users\CompanyUserRepository;
use Input;

class CompanyUserController extends Controller
{
    /**
     * @var \EQM\Models\Companies\Users\CompanyUserRepository
     */
    private $companyUsers;

    public function __construct(CompanyUserRepository $companyUsers)
    {
        $this->companyUsers = $companyUsers;
    }

    public function index(Company $company)
    {
        $companyUsers = $this->companyUsers->findByCompanyPaginated($company, Input::get('limit', 10));
        
        return $this->response()->paginator($companyUsers, new CompanyUserTransformer());
    }
}
