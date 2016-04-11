<?php
namespace EQM\Models\Advertising\Companies;

interface AdvertisingCompanyRepository
{
    /**
     * @param array $values
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany
     */
    public function create(array $values);

    /**
     * @param \EQM\Models\Advertising\Companies\AdvertisingCompany $advertisingCompany
     * @param array $values
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany
     */
    public function update(AdvertisingCompany $advertisingCompany, array $values);

    /**
     * @param \EQM\Models\Advertising\Companies\AdvertisingCompany $advertisingCompany
     */
    public function delete(AdvertisingCompany $advertisingCompany);

    /**
     * @param $id
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany|null
     */
    public function findById($id);

    /**
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany[]
     */
    public function findAll();
    
    public function findAllPaginated($limit = 10);
}
