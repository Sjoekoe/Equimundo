<?php
namespace EQM\Listeners\Events;

use EQM\Events\HorseWasCreated;
use EQM\Models\Albums\Album;

class CreateStandardAlbums
{
    /**
     * @param \EQM\Events\HorseWasCreated $event
     */
    public function handle(HorseWasCreated $event)
    {
        $profileAlbum = new Album();
        $profileAlbum->horse_id = $event->horse->id;
        $profileAlbum->name = 'profile_pictures';
        $profileAlbum->setProfileAlbum();
        $profileAlbum->save();

        $coverAlbum = new Album();
        $coverAlbum->horse_id = $event->horse->id;
        $coverAlbum->name = 'cover_album';
        $coverAlbum->setCoverAlbum();
        $coverAlbum->save();

        $timeLineAlbum = new Album();
        $timeLineAlbum->horse_id = $event->horse->id;
        $timeLineAlbum->name = 'timeline_album';
        $timeLineAlbum->setTimeLineAlbum();
        $timeLineAlbum->save();
    }
}
