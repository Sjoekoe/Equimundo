<?php
namespace EQM\Core\Advertisements;

class SkyScraper implements AdObject
{
    public function name()
    {
        return 'SkyScraper';
    }

    public function type()
    {
        return self::SKYSCRAPER;
    }

    public function width()
    {
        return '120';
    }

    public function height()
    {
        return '600';
    }

    public function price()
    {
        return '1500';
    }
}
