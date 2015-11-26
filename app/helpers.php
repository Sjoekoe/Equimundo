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
     * @param string|null $format
     * @return string
     */
    function eqm_date($date = null, $format = null)
    {
        $format = $format ?: auth()->user()->dateFormat();

        return $date && $date !== '' ? $date->format($format) : '';
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
