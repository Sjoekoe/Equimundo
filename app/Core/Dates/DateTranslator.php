<?php
namespace EQM\Core\Dates;

use DateTime;
use Jenssegers\Date\Date;

class DateTranslator
{
    /**
     * @param \DateTime $dateTime
     * @return \Jenssegers\Date\Date
     */
    public function translate(DateTime $dateTime)
    {
        $date = Date::parse($dateTime);
        $date->setLocale(eqm_locale());

        return $date;
    }
}
