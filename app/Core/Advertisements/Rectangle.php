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
        return '150';
    }

    public function height()
    {
        return '180';
    }

    public function price()
    {
        return '800';
    }
}
