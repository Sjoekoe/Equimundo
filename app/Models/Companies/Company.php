<?php
namespace EQM\Models\Companies;

interface Company
{
    const TABLE = 'companies';

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function slug();

    /**
     * @return string
     */
    public function website();

    /**
     * @return string
     */
    public function telephone();

    /**
     * @return string
     */
    public function about();

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

    /**
     * @return \EQM\Models\Addresses\Address
     */
    public function address();

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function userTeams();

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function followers();
}
