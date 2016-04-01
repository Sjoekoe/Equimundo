<?php
namespace EQM\Core\Advertisements;

class Rectangle implements AdObject
{
    public function name()
    {
        return 'Rectangle';
    }

    public function type()
    {
        return self::RECTANGLE;
    }

    public function width()
    {
        return '150px';
    }

    public function height()
    {
        return '180px';
    }

    public function price()
    {
        return '800';
    }
}
