<?php
namespace EQM\Api\Http\Controllers\Companies;

use EQM\Api\Companies\CompanyTransformer;
use EQM\Api\Companies\Jobs\CreatesCompany;
use EQM\Api\Companies\Requests\StoreCompanyRequest;
use EQM\Api\Http\Controller;
use EQM\Models\Companies\Company;
use EQM\Models\Companies\CompanyRepository;
use Illuminate\Bus\Dispatcher;
use Input;

class CompanyController extends Controller
{
    /**
     * @var \EQM\Models\Companies\CompanyRepository
     */
    private $companies;

    /**
     * @var \Illuminate\Bus\Dispatcher
     */
    private $dispatcher;

    public function __construct(CompanyRepository $companies, Dispatcher $dispatcher)
    {
        $this->companies = $companies;
        $this->dispatcher = $dispatcher;
    }

    public function index()
    {
        $companies = $this->companies->findAllPaginated(Input::get('limit', 10));

        return $this->response()->paginator($companies, new CompanyTransformer());
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = $this->dispatcher->dispatch(new CreatesCompany(auth()->user(), $request->all()));

        return $this->response()->item($company, new CompanyTransformer());
    }

    public function show(Company $company)
    {
        return $this->response()->item($company, new CompanyTransformer());
    }
    
    public function delete(Company $company)
    {
        $this->companies->delete($company);
        
        return $this->response()->noContent();
    }
}
