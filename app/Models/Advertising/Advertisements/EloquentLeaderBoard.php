<?php
namespace EQM\Models\Advertising\Advertisements;

use EQM\Core\Advertisements\AdObject;

class EloquentLeaderBoard extends EloquentAdvertisement implements AdObject, LeaderBoard
{
    /**
     * @var string
     */
    protected static $singleTableType = self::NAME;

    public function name()
    {
        return self::NAME;
    }

    public function type()
    {
        return self::TYPE;
    }

    public function width()
    {
        return self::WIDTH;
    }

    public function height()
    {
        return self::HEIGHT;
    }

    public function price()
    {
        return '1500';
    }
}
