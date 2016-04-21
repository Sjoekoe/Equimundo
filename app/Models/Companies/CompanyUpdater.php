<?php
namespace EQM\Models\Companies;

use EQM\Core\Database\CanMakeDatabaseTransactions;
use EQM\Core\Database\TransactionManager;
use EQM\Models\Addresses\AddressRepository;

class CompanyUpdater
{
    use CanMakeDatabaseTransactions;

    /**
     * @var \EQM\Models\Addresses\AddressRepository
     */
    private $addresses;

    /**
     * @var \EQM\Models\Companies\CompanyRepository
     */
    private $companies;

    public function __construct(
        TransactionManager $transactionManager, 
        AddressRepository $addresses, 
        CompanyRepository $companies
    ) {
        $this->transactionManager = $transactionManager;
        $this->addresses = $addresses;
        $this->companies = $companies;
    }

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param array $values
     * @return \EQM\Models\Companies\Company|mixed
     */
    public function update(Company $company, array $values)
    {
        $company = $this->transaction(function() use ($company, $values) {
            $address = $this->addresses->update($company->address(), $values);
            $values['address_id'] = $address->id();
            $company = $this->companies->update($company, $values);
            
            return $company;
        });
        
        return $company;
    }
}
