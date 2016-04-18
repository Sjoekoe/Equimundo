<?php
namespace EQM\Api\Http\Controllers\Companies;

use EQM\Api\Http\Controller;
use EQM\Api\Statuses\CompanyStatusTransformer;
use EQM\Api\Statuses\Requests\StoreCompanyStatusRequest;
use EQM\Core\Files\Uploader;
use EQM\Models\Companies\Company;
use EQM\Models\Statuses\StatusRepository;

class CompanyStatusController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    public function __construct(StatusRepository $statuses, Uploader $uploader)
    {
        $this->statuses = $statuses;
        $this->uploader = $uploader;
    }

    public function index(Company $company)
    {
        $statuses = $this->statuses->findForCompanyPaginated($company);

        return $this->response()->paginator($statuses, new CompanyStatusTransformer());
    }

    public function store(StoreCompanyStatusRequest $request, Company $company)
    {
        $status = $this->statuses->createForCompany($company, $request->all());

        if (array_key_exists('picture', $request->all()) && $request->get('picture') !== 'undefined') {
            $picture = $this->uploader->uploadForCompany($request->file('picture'), $company);

            $status->setPicture($picture);

            $status->save();
        }

        return $this->response()->item($status, new CompanyStatusTransformer());
    }
}
