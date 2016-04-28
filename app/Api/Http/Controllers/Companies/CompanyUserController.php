<?php
namespace EQM\Api\Http\Controllers\Companies;

use EQM\Api\Companies\CompanyUserTransformer;
use EQM\Api\Http\Controller;
use EQM\Models\Companies\Company;
use EQM\Models\Companies\Users\CompanyUserRepository;
use EQM\Models\Users\User;
use Illuminate\Http\Request;
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

    public function store(Request $request, Company $company)
    {
        $companyUser = $this->companyUsers->create(auth()->user(), $company, $request->get('type'), $request->get('is_admin'));

        return $this->response()->item($companyUser, new CompanyUserTransformer());
    }

    public function show(Company $company, User $user)
    {
        $companyUser = $this->companyUsers->findByCompanyAndUser($company, $user);

        return $this->response()->item($companyUser, new CompanyUserTransformer());
    }

    public function delete(Company $company, User $user)
    {
        $this->companyUsers->deleteByCompanyAndUser($company, $user);

        return $this->response()->noContent();
    }
}
