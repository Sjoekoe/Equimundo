<?php
namespace EQM\Core\Advertisements;

interface AdObject
{
    const RECTANGLE = 1;
    const FULL_PAGE = 2;
    const LEADERBOARD = 3;
    const SKYSCRAPER = 4;
    const EVENT = 5;
    const STATUS = 6;
    const CONTENT_PAGE = 7;
    const NEWSLETTER = 8;

    public function name();

    public function type();

    public function width();

    public function height();

    public function price();
}
