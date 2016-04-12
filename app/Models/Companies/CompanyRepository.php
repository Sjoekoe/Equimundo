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
     * @param string $slug
     * @return int
     */
    public function findSlugCount($slug);
}
