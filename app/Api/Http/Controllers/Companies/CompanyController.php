<?php
namespace EQM\Api\Http\Controllers\Companies;

use EQM\Api\Companies\CompanyTransformer;
use EQM\Api\Companies\Requests\StoreCompanyRequest;
use EQM\Api\Companies\Requests\UpdateCompanyRequest;
use EQM\Api\Http\Controller;
use EQM\Models\Companies\Company;
use EQM\Models\Companies\CompanyCreator;
use EQM\Models\Companies\CompanyRepository;
use EQM\Models\Companies\CompanyUpdater;
use Input;

class CompanyController extends Controller
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
        $companies = $this->companies->findAllPaginated(Input::get('limit', 10));

        return $this->response()->paginator($companies, new CompanyTransformer());
    }

    public function store(StoreCompanyRequest $request, CompanyCreator $creator)
    {
        $company = $creator->create(auth()->user(), $request->all());

        return $this->response()->item($company, new CompanyTransformer());
    }

    public function show(Company $company)
    {
        return $this->response()->item($company, new CompanyTransformer());
    }

    public function update(StoreCompanyRequest $request, CompanyUpdater $updater, Company $company)
    {
        $company = $updater->update($company, $request->all());

        return $this->response()->item($company, new CompanyTransformer());
    }

    public function delete(Company $company)
    {
        $this->companies->delete($company);

        return $this->response()->noContent();
    }
}
