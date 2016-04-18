<?php
namespace EQM\Api\Http\Controllers\Companies;

use EQM\Api\Http\Controller;
use EQM\Api\Statuses\CompanyStatusTransformer;
use EQM\Api\Statuses\Requests\StoreCompanyStatusRequest;
use EQM\Models\Companies\Company;
use EQM\Models\Statuses\StatusRepository;

class CompanyStatusController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    public function __construct(StatusRepository $statuses)
    {
        $this->statuses = $statuses;
    }

    public function index(Company $company)
    {
        $statuses = $this->statuses->findForCompanyPaginated($company);

        return $this->response()->paginator($statuses, new CompanyStatusTransformer());
    }

    public function store(StoreCompanyStatusRequest $request, Company $company)
    {
        $status = $this->statuses->createForCompany($company, $request->all());

        return $this->response()->item($status, new CompanyStatusTransformer());
    }
}
