<?php
namespace EQM\Models\Palmares;

interface Palmares
{
    /**
     * @return int
     */
    public function id();

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse();

    /**
     * @return \EQM\Models\Events\Event
     */
    public function event();

    /**
     * @return \EQM\Models\Statuses\Status
     */
    public function status();

    /**
     * @return int
     */
    public function discipline();

    /**
     * @return string
     */
    public function ranking();

    /**
     * @return string
     */
    public function level();

    /**
     * @return \dateTime
     */
    public function date();
}
