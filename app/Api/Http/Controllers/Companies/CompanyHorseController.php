<?php
namespace EQM\Api\Http\Controllers\Companies;

use EQM\Api\Companies\CompanyHorseTransformer;
use EQM\Api\Companies\Requests\StoreCompanyHorseRequest;
use EQM\Api\Http\Controller;
use EQM\Models\Companies\Company;
use EQM\Models\Companies\Horses\CompanyHorseRepository;
use EQM\Models\Horses\Horse;

class CompanyHorseController extends Controller
{
    /**
     * @var \EQM\Models\Companies\Horses\CompanyHorseRepository
     */
    private $companyHorses;

    public function __construct(CompanyHorseRepository $companyHorses)
    {
        $this->companyHorses = $companyHorses;
    }

    public function index(Company $company)
    {
        $horses = $this->companyHorses->findByCompanyPaginated($company);

        return $this->response()->paginator($horses, new CompanyHorseTransformer());
    }

    public function store(StoreCompanyHorseRequest $request, Company $company)
    {
        $companyHorse = $this->companyHorses->create($company, $request->get('horse_id'));

        return $this->response()->item($companyHorse, new CompanyHorseTransformer());
    }

    public function show(Company $company, Horse $horse)
    {
        $companyHorse = $this->companyHorses->findByCompanyAndHorse($company, $horse);

        return $this->response()->item($companyHorse, new CompanyHorseTransformer());
    }
    
    public function delete(Company $company, Horse $horse)
    {
        $companyHorse = $this->companyHorses->findByCompanyAndHorse($company, $horse);
        $this->companyHorses->delete($companyHorse);
        
        return $this->response()->noContent();
    }
}
