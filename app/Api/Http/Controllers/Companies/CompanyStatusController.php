<?php
namespace EQM\Api\Http\Controllers\Companies;

use EQM\Api\Http\Controller;
use EQM\Api\Statuses\CompanyStatusTransformer;
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
}
