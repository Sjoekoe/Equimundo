<?php
namespace EQM\Api\Http\Controllers\Admin;

use EQM\Api\Advertising\AdvertisingCompanyTransformer;
use EQM\Api\Advertising\Requests\AdvertisingCompanyRequest;
use EQM\Api\Http\Controller;
use EQM\Models\Advertising\Companies\AdvertisingCompany;
use EQM\Models\Advertising\Companies\AdvertisingCompanyRepository;
use Input;

class CompanyController extends Controller
{
    /**
     * @var \EQM\Models\Advertising\Companies\AdvertisingCompanyRepository
     */
    private $advertisingCompanies;

    public function __construct(AdvertisingCompanyRepository $advertisingCompanies)
    {
        $this->advertisingCompanies = $advertisingCompanies;
    }

    public function index()
    {
        $companies = $this->advertisingCompanies->findAllPaginated(Input::get('limit', 10));

        return $this->response()->paginator($companies, new AdvertisingCompanyTransformer());
    }

    public function store(AdvertisingCompanyRequest $request)
    {
        $company = $this->advertisingCompanies->create($request->all());

        return $this->response()->item($company, new AdvertisingCompanyTransformer());
    }

    public function show(AdvertisingCompany $advertisingCompany)
    {
        return $this->response()->item($advertisingCompany, new AdvertisingCompanyTransformer());
    }

    public function update(AdvertisingCompanyRequest $request, AdvertisingCompany $advertisingCompany)
    {
        $company = $this->advertisingCompanies->update($advertisingCompany, $request->all());

        return $this->response()->item($company, new AdvertisingCompanyTransformer());
    }

    public function delete(AdvertisingCompany $advertisingCompany)
    {
        $this->advertisingCompanies->delete($advertisingCompany);

        return $this->response()->noContent();
    }
}
