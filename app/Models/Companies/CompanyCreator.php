<?php
namespace EQM\Models\Companies;

use EQM\Core\Database\CanMakeDatabaseTransactions;
use EQM\Core\Database\TransactionManager;
use EQM\Models\Addresses\AddressRepository;
use EQM\Models\Companies\Users\CompanyUserRepository;
use EQM\Models\Users\User;

class CompanyCreator
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

    /**
     * @var \EQM\Models\Companies\Users\CompanyUserRepository
     */
    private $companyUsers;

    public function __construct(
        TransactionManager $transactionManager,
        AddressRepository $addresses,
        CompanyRepository $companies,
        CompanyUserRepository $companyUsers
    ) {
        $this->transactionManager = $transactionManager;
        $this->addresses = $addresses;
        $this->companies = $companies;
        $this->companyUsers = $companyUsers;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Companies\Company
     */
    public function create(User $user, array $values)
    {
        $company = $this->transaction(function() use ($user, $values) {
            $address = $this->addresses->create($values);
            $company = $this->companies->create($address, $values);
            $this->companyUsers->create($user, $company, $values['type'], true);

            return $company;
        });

        return $company;
    }
}
