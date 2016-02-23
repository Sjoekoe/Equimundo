<?php
namespace EQM\Listeners\Events;

use EQM\Events\SearchWasPerformed;
use EQM\Models\Searches\SearchRepository;

class UpdateSearchTable
{
    /**
     * @var \EQM\Models\Searches\SearchRepository
     */
    private $searches;

    public function __construct(SearchRepository $searches)
    {
        $this->searches = $searches;
    }

    /**
     * @param \EQM\Events\SearchWasPerformed $event
     */
    public function handle(SearchWasPerformed $event)
    {
        if ($search = $this->searches->findByTerm($event->term)) {
            $this->searches->update($search, $event->resultCount);
        } else {
            $this->searches->create($event->term, $event->resultCount);
        }
    }
}
