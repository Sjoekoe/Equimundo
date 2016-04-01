<?php
namespace EQM\Core\Advertisements;

class LeaderBoard implements AdObject
{
    public function name()
    {
        return 'Leader Board';
    }

    public function type()
    {
        return self::LEADERBOARD;
    }

    public function width()
    {
        return '728px';
    }

    public function height()
    {
        return '90px';
    }

    public function price()
    {
        return '1500';
    }
}
