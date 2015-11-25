<?php
namespace EQM\Core\Dates;

use DateTime;

interface DateTranslator
{
    /**
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public function translate(DateTime $dateTime);
}
