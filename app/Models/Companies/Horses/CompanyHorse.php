<?php
namespace EQM\Models\Companies\Horses;

interface CompanyHorse
{
    const TABLE = 'company_horses';
    
    /**
     * @return int
     */
    public function id();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse();

    /**
     * @return \EQM\Models\Companies\Company
     */
    public function company();

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();
}
