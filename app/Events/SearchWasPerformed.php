<?php
namespace EQM\Events;

class SearchWasPerformed extends Event
{
    /**
     * @var string
     */
    public $term;

    /**
     * @var
     */
    public $resultCount;

    public function __construct($term, $resultCount)
    {
        $this->term = $term;
        $this->resultCount = $resultCount;
    }
}
