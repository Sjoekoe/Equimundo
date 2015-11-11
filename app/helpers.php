<?php

use Carbon\Carbon;

if (! function_exists('locale')) {
    /**
     * @return string
     */
    function eqm_locale()
    {
        return auth()->check() ? auth()->user()->getLocale() : 'en';
    }
}

if (! function_exists('eqm_date')) {
    function eqm_date(Carbon $date)
    {
        return $date->format(auth()->user()->date_format);
    }
}
