<?php
namespace functional\Api\Events;

use Carbon\Carbon;
use DB;
use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Addresses\Address;
use EQM\Models\Events\Event;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventsTest extends \TestCase
{
    use DefaultIncludes, DatabaseTransactions;

    /** @test */
    function it_can_get_all_events_paginated()
    {
        $user = $this->createUser();
        $address = $this->createAddress();
        $event = $this->createEvent([
            'creator_id' => $user->id(),
            'address_id' => $address->id(),
            'place' => $address->state(),
        ]);

        $this->get('/api/events')->seeJsonEquals([
            'data' => [
                $this->includedEvent($event),
            ],
            'meta' => [
                'pagination' => [
                    'count' => 1,
                    'current_page' => 1,
                    'links' => [],
                    'per_page' => 10,
                    'total' => 1,
                    'total_pages' => 1,
                ],
            ]
        ]);
    }

    /** @test */
    function it_can_create_an_event()
    {
        $user = $this->loginAsUser();

        $start = Carbon::now();
        $end = Carbon::now()->addDay();

        $this->post('/api/events', [
            'name' => 'Test event',
            'street' => 'Vogelzangstraat 12',
            'start_date' => $start->format('d/m/Y'),
            'end_date' => $end->format('d/m/Y'),
            'city' => 'Lokeren',
            'zip' => '9160',
            'state' => 'Oost-vlaanderen',
            'country' => 'BE',
            'description' => 'Test description',
        ])->seeJsonEquals([
            'data' => [
                'id' => DB::table(Event::TABLE)->first()->id,
                'name' => 'Test event',
                'description' => 'Test description',
                'place' => 'Lokeren',
                'start_date' => $start->toIso8601String(),
                'end_date' => $end->toIso8601String(),
                'creatorRelation' => $this->includedUser($user),
                'addressRelation' => [
                    'data' => [
                        'id' => DB::table(Address::TABLE)->first()->id,
                        'street' => 'Vogelzangstraat 12',
                        'zip' => '9160',
                        'city' => 'Lokeren',
                        'state' => 'Oost-vlaanderen',
                        'country' => 'BE',
                        'latitude' => '51.0763681',
                        'longitude' => '3.9454076',
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    function it_can_show_an_event()
    {
        $user = $this->createUser();
        $address = $this->createAddress();
        $event = $this->createEvent([
            'creator_id' => $user->id(),
            'address_id' => $address->id(),
            'place' => $address->state(),
        ]);

        $this->get('/api/events/' . $event->id())
            ->seeJsonEquals([
                'data' => $this->includedEvent($event),
            ]);
    }

    /** @test */
    function it_can_update_an_event()
    {
        $user = $this->createUser();
        $address = $this->createAddress();
        $event = $this->createEvent([
            'creator_id' => $user->id(),
            'address_id' => $address->id(),
            'place' => $address->state(),
        ]);

        $this->put('/api/events/' . $event->id(), [
            'name' => 'updated name',
            'description' => 'Updated description',
            'street' => 'Foo street',
            'city' => 'Baz City',
            'state' => 'Antwerp',
            'country' => 'BE',
            'zip' => '2000',
        ])->seeJsonEquals([
            'data' => $this->includedEvent($event, [
                'name' => 'updated name',
                'description' => 'Updated description',
                'place' => $address->city(),
                'addressRelation' => [
                    'data' => [
                        'id' => $address->id() + 1,
                        'city' => $address->city(),
                        'country' => $address->country(),
                        'state' => $address->state(),
                        'street' => $address->street(),
                        'zip' => $address->zip(),
                        'latitude' => '44.4495134',
                        'longitude' => '-102.0783189'
                    ]
                ]
            ])
        ]);
    }

    /** @test */
    function it_can_delete_an_event()
    {
        $user = $this->createUser();
        $address = $this->createAddress();
        $event = $this->createEvent([
            'creator_id' => $user->id(),
            'address_id' => $address->id(),
            'place' => $address->state(),
        ]);

        $this->seeInDatabase(Event::TABLE, [
            'id' => $event->id(),
        ]);

        $this->delete('/api/events/' . $event->id())
            ->assertNoContent();

        $this->missingFromDatabase(Event::TABLE, [
            'id' => $event->id(),
        ]);
    }
}
