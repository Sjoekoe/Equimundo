<?php
namespace EQM\Models\Events;

interface Event
{
    const TABLE = 'events';
    
    /**
     * @return int
     */
    public function id();

    /**
     * @return \EQM\Models\Users\User
     */
    public function creator();

    /**
     * @return \EQM\Models\Palmares\Palmares[]
     */
    public function palmares();

    /**
     * @return string
     */
    public function name();

    /**
     * @return int
     */
    public function place();

    /**
     * @return string
     */
    public function description();

    /**
     * @return \Carbon\Carbon|null
     */
    public function startDate();

    /**
     * @return \Carbon\Carbon|null
     */
    public function endDate();

    /**
     * @return \EQM\Models\Addresses\Address
     */
    public function address();
}
