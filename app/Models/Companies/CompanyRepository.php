<?php
namespace EQM\Models\Companies;

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
     */
    public function delete(Company $company);

    public function findAllPaginated($limit = 10);

    /**
     * @param string $slug
     * @return \EQM\Models\Companies\Company|null
     */
    public function findBySlug($slug);

    /**
     * @param string $slug
     * @return int
     */
    public function findSlugCount($slug);
}
