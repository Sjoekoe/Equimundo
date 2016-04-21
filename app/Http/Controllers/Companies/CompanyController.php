<?php
namespace EQM\Http\Controllers\Companies;

use EQM\Core\Info\Info;
use EQM\Http\Controllers\Controller;
use EQM\Models\Companies\Company;
use EQM\Models\Companies\Horses\CompanyHorseRepository;
use EQM\Models\Horses\Horse;

class CompanyController extends Controller
{
    /**
     * @var \EQM\Models\Companies\Horses\CompanyHorseRepository
     */
    private $companyHorses;

    public function __construct(CompanyHorseRepository $companyHorses)
    {
        $this->companyHorses = $companyHorses;
    }
    
    public function create()
    {
        return view('companies.create');
    }

    public function show(Info $info, Company $company)
    {
        $info->flash([
            'company' => $company->slug(),
            'latitude' => $company->address()->latitude(),
            'longitude' => $company->address()->longitude(),
        ]);

        return view('companies.show', compact('company'));
    }
    
    public function follow(Company $company, Horse $horse)
    {
        if ($horse->isFollowingCompany($company)) {
            $companyHorse = $this->companyHorses->findByCompanyAndHorse($company, $horse);
            
            $this->companyHorses->delete($companyHorse);
        } else {
            $this->companyHorses->create($company, $horse->id());
        }
        
        return back();
    }
}
