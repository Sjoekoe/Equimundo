<?php

use Carbon\Carbon;
use EQM\Core\Dates\DateTranslator;

if (! function_exists('locale')) {
    /**
     * @return string
     */
    function eqm_locale()
    {
        return auth()->check() ? auth()->user()->language() : 'en';
    }
}

if (! function_exists('eqm_date')) {
    /**
     * @param \Carbon\Carbon $date
     * @return string
     */
    function eqm_date(Carbon $date)
    {
        return $date->format(auth()->user()->dateFormat());
    }
}

if (! function_exists('eqm_translated_date')) {
    /**
     * @param \Carbon\Carbon $date
     * @return \Carbon\Carbon|\Jenssegers\Date\Date
     */
    function eqm_translated_date(Carbon $date)
    {
        return app(DateTranslator::class)->translate($date);
    }
}
