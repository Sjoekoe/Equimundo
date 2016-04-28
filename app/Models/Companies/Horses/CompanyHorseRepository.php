<?php
namespace EQM\Models\Companies\Horses;

use EQM\Models\Companies\Company;
use EQM\Models\Horses\Horse;

interface CompanyHorseRepository
{
    /**
     * @param \EQM\Models\Companies\Company $company
     * @param int $horseId
     * @return \EQM\Models\Companies\Horses\CompanyHorse
     */
    public function create(Company $company, $horseId);

    /**
     * @param \EQM\Models\Companies\Horses\CompanyHorse $companyHorse
     */
    public function delete(CompanyHorse $companyHorse);
    
    /**
     * @param \EQM\Models\Companies\Company $company
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findByCompanyPaginated(Company $company, $limit = 10);

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Companies\Horses\CompanyHorse
     */
    public function findByCompanyAndHorse(Company $company, Horse $horse);
}
