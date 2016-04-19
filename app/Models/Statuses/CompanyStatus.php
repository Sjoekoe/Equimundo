<?php
namespace EQM\Models\Statuses;

interface CompanyStatus
{
    const TYPE = 'company';
    
    /**
     * @return \EQM\Models\Companies\Company
     */
    public function company();

    /**
     * @return string
     */
    public function type();
    
    public function poster();
}
