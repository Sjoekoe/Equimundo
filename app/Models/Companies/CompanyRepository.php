<?php
namespace EQM\Models\Companies;

use Carbon\Carbon;
use EQM\Models\Addresses\Address;

interface CompanyRepository
{
    /**
     * @param \EQM\Models\Addresses\Address $address
     * @param array $values
     * @return \EQM\Models\Companies\Company
     */
    public function create(Address $address, array $values);

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param array $values
     * @return \EQM\Models\Companies\Company
     */
    public function update(Company $company, array $values);

    /**
     * @param \EQM\Models\Companies\Company $company
     */
    public function delete(Company $company);

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllPaginated($limit = 10);

    /**
     * @param string $slug
     * @return \EQM\Models\Companies\Company|null
     */
    public function findBySlug($slug);

    /**
     * @param int $id
     * @return \EQM\Models\Companies\Company|null
     */
    public function findById($id);

    /**
     * @param string $slug
     * @return int
     */
    public function findSlugCount($slug);

    /**
     * @param string $keyWord
     * @return \EQM\Models\Companies\Company[]
     */
    public function search($keyWord);

    /**
     * @return mixed
     */
    public function count();

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginated($limit = 10);
    
    public function findCountByDate(Carbon $start, Carbon $end);
    
    public function findRegisteredUsersBeforeDate(Carbon $date);
}
