<?php
namespace EQM\Models\Events;

interface Event
{
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
     * @return \DateTime
     */
    public function startDate();

    /**
     * @return \DateTime
     */
    public function endDate();
}
