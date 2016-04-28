<?php
namespace EQM\Models\Companies\Horses;

use EQM\Models\Companies\Company;
use EQM\Models\Horses\Horse;

class EloquentCompanyHorseRepository implements CompanyHorseRepository
{
    /**
     * @var \EQM\Models\Companies\Horses\EloquentCompanyHorse
     */
    private $companyHorse;

    public function __construct(EloquentCompanyHorse $companyHorse)
    {
        $this->companyHorse = $companyHorse;
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param int $horseId
     * @return \EQM\Models\Companies\Horses\CompanyHorse
     */
    public function create(Company $company, $horseId)
    {
        $companyHorse = new EloquentCompanyHorse();
        $companyHorse->company_id = $company->id();
        $companyHorse->horse_id = $horseId;

        $companyHorse->save();

        return $companyHorse;
    }

    /**
     * @param \EQM\Models\Companies\Horses\CompanyHorse $companyHorse
     */
    public function delete(CompanyHorse $companyHorse)
    {
        $companyHorse->delete();
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findByCompanyPaginated(Company $company, $limit = 10)
    {
        return $this->companyHorse
            ->where('company_id', $company->id())
            ->latest()
            ->paginate($limit);
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Companies\Horses\CompanyHorse
     */
    public function findByCompanyAndHorse(Company $company, Horse $horse)
    {
        return $this->companyHorse
            ->where('company_id', $company->id())
            ->where('horse_id', $horse->id())
            ->first();
    }
}
