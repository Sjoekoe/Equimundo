<?php
namespace EQM\Models\Companies\Users;

interface CompanyUser
{
    const TABLE = 'company_user';

    /**
     * @return int
     */
    public function id();

    /**
     * @return \EQM\Models\Users\User
     */
    public function user();

    /**
     * @return \EQM\Models\Companies\Company
     */
    public function company();

    /**
     * @return string
     */
    public function type();

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();
}
