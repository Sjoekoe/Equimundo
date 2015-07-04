<?php

if (! function_exists('locale')) {
    function locale()
    {
        return Auth::check() ? Auth::user()->getLocale() : 'en';
    }
}
