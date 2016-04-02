<?php
namespace functional\Api\Advertisements;

use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Advertising\Contacts\AdvertisingContact;

class ContactsTest extends \TestCase
{
    use DefaultIncludes;

    /** @test */
    function it_can_get_all_contacts()
    {
        $advertisingContact = $this->createAdvertisingContact();

        $this->get('/api/admin/advertisements/contacts')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => $advertisingContact->id(),
                        'email' => $advertisingContact->email(),
                        'first_name' => $advertisingContact->firstName(),
                        'last_name' => $advertisingContact->lastName(),
                        'telephone' => $advertisingContact->telephone(),
                    ]
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
                ],
            ]);
    }

    /** @test */
    function it_can_create_an_advertising_contact()
    {
        $this->post('/api/admin/advertisements/contacts', [
            'first_name' => 'foo',
            'last_name' => 'bar',
            'email' => 'foo@bar.com',
            'telephone' => '5678',
        ])->seeJsonEquals([
            'data' => [
                'id' => 1,
                'first_name' => 'foo',
                'last_name' => 'bar',
                'email' => 'foo@bar.com',
                'telephone' => '5678',
            ],
        ]);
    }

    /** @test */
    function it_can_show_an_advertising_contact()
    {
        $contact = $this->createAdvertisingContact();

        $this->get('/api/admin/advertisements/contacts/' . $contact->id())
            ->seeJsonEquals(
                $this->includedAdvertisingContact($contact)
            );
    }

    /** @test */
    function it_can_update_an_advertising_contact()
    {
        $contact = $this->createAdvertisingContact();

        $this->put('/api/admin/advertisements/contacts/' . $contact->id(), [
            'first_name' => 'Jef',
            'last_name' => 'Baz',
            'email' => 'jef@baz.com',
            'telephone' => '4093'
        ])
            ->seeJsonEquals(
                $this->includedAdvertisingContact($contact, [
                    'first_name' => 'Jef',
                    'last_name' => 'Baz',
                    'email' => 'jef@baz.com',
                    'telephone' => '4093'
                ])
            );
    }

    /** @test */
    function it_can_delete_an_advertising_contact()
    {
        $contact = $this->createAdvertisingContact();

        $this->seeInDatabase(AdvertisingContact::TABLE, [
            'id' => $contact->id(),
        ]);

        $this->delete('/api/admin/advertisements/contacts/' . $contact->id())
            ->assertResponseStatus(204);

        $this->notSeeInDatabase(AdvertisingContact::TABLE, [
            'id' => $contact->id(),
        ]);
    }
}
