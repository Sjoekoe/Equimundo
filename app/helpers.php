<?php

if (! function_exists('locale')) {
    /**
     * @return string
     */
    function locale()
    {
        return Auth::check() ? Auth::user()->getLocale() : 'en';
    }
}
