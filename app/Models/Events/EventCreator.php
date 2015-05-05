<?php
namespace HorseStories\Models\Events;

use Illuminate\Auth\AuthManager;

class EventCreator
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param array $data
     * @return \HorseStories\Models\Events\Event
     */
    public function create($data = [])
    {
        $event = new Event();

        $event->name = $data['event_name'];
        $event->date = $data['date'];
        $event->creator_id = $this->auth->user()->id;

        $event->save();

        return $event;
    }
}