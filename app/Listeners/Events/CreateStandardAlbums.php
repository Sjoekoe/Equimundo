<?php
namespace EQM\Listeners\Events;

use EQM\Events\HorseWasCreated;
use EQM\Models\Albums\Album;
use EQM\Models\Albums\AlbumRepository;

class CreateStandardAlbums
{
    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    /**
     * @param \EQM\Models\Albums\AlbumRepository $albums
     */
    public function __construct(AlbumRepository $albums)
    {
        $this->albums = $albums;
    }

    /**
     * @param \EQM\Events\HorseWasCreated $event
     */
    public function handle(HorseWasCreated $event)
    {
        $this->albums->createStandardAlbums($event->horse);
    }
}
