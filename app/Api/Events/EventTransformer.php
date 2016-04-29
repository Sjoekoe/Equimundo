<?php
namespace EQM\Api\Events;

use EQM\Api\Addresses\AddressTransformer;
use EQM\Api\Users\UserTransformer;
use EQM\Models\Events\Event;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'creatorRelation',
        'addressRelation'
    ];

    /**
     * @param \EQM\Models\Events\Event $event
     * @return array
     */
    public function transform(Event $event)
    {
        return [
            'id' => $event->id(),
            'name' => $event->name(),
            'description' => $event->description(),
            'start_date' => $event->startDate() ? $event->startDate()->toIso8601String() : null,
            'end_date' => $event->endDate() ? $event->endDate()->toIso8601String() : null,
            'place' => $event->place(),
        ];
    }

    /**
     * @param \EQM\Models\Events\Event $event
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeAddressRelation(Event $event)
    {
        return $event->address() ? $this->item($event->address(), new AddressTransformer()) : null;
    }

    /**
     * @param \EQM\Models\Events\Event $event
     * @return \League\Fractal\Resource\Item
     */
    public function includeCreatorRelation(Event $event)
    {
        return $this->item($event->creator(), new UserTransformer());
    }
}
