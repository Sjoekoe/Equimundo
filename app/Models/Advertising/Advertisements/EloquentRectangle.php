<?php
namespace EQM\Models\Advertising\Advertisements;

use EQM\Core\Advertisements\AdObject;

class EloquentRectangle extends EloquentAdvertisement implements AdObject, Rectangle
{
    /**
     * @var string
     */
    protected static $singleTableType = self::NAME;

    /**
     * @return string
     */
    public function name()
    {
        return self::NAME;
    }

    /**
     * @return int
     */
    public function type()
    {
        return self::TYPE;
    }

    /**
     * @return string
     */
    public function width()
    {
        return self::WIDTH;
    }

    /**
     * @return string
     */
    public function height()
    {
        return self::HEIGHT;
    }

    /**
     * @return string
     */
    public function price()
    {
        return '800';
    }
}
