<?php
namespace EQM\Api\Companies\Jobs;

use EQM\Core\Database\CanMakeDatabaseTransactions;
use EQM\Core\Database\TransactionManager;
use EQM\Jobs\Job;
use EQM\Models\Addresses\AddressRepository;
use EQM\Models\Companies\CompanyRepository;
use EQM\Models\Companies\Users\CompanyUserRepository;
use EQM\Models\Users\User;

class CreatesCompany extends Job
{
    use CanMakeDatabaseTransactions;

    /**
     * @var \EQM\Models\Users\User
     */
    private $user;

    /**
     * @var array
     */
    private $values;

    public function __construct(User $user, array $values)
    {
        $this->transactionManager = app(TransactionManager::class);
        $this->user = $user;
        $this->values = $values;
    }

    /**
     * @param \EQM\Models\Addresses\AddressRepository $addresses
     * @param \EQM\Models\Companies\CompanyRepository $companies
     * @param \EQM\Models\Companies\Users\CompanyUserRepository $companyUsers
     * @return \EQM\Models\Companies\Company
     */
    public function handle(AddressRepository $addresses, CompanyRepository $companies, CompanyUserRepository $companyUsers)
    {
        $this->transaction(function() use ($addresses, $companies, $companyUsers) {
            $address = $addresses->create($this->values);
            $company = $companies->create($address, $this->values);
            $companyUsers->create($this->user, $company, $this->values['type'], true);

            return $company;
        });
    }
}
