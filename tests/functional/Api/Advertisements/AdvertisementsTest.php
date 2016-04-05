<?php
namespace functional\Api\Advertisements;

use Carbon\Carbon;
use EQM\Core\Advertisements\AdObject;
use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Advertising\Advertisements\Advertisement;

class AdvertisementsTest extends \TestCase
{
    use DefaultIncludes;

    /** @test */
    function it_can_get_all_advertisements()
    {
        $company = $this->createCompleteAdvertisingCompany();
        $advertisement = $this->createAdvertisement([
            'adv_company_id' => $company->id(),
        ]);

        $this->get('/api/admin/advertisements')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => $advertisement->id(),
                        'start' => $advertisement->start()->toIso8601String(),
                        'end' => $advertisement->end()->toIso8601String(),
                        'type' => AdObject::RECTANGLE,
                        'views' => $advertisement->views(),
                        'clicks' => $advertisement->clicks(),
                        'amount' => $advertisement->amount(),
                        'paid' => $advertisement->paid(),
                        'website' => $advertisement->website(),
                        'companyRelation' => [
                            'data' => [
                                'id' => $company->id(),
                                'name' => $company->name(),
                                'email' => $company->email(),
                                'telephone' => $company->telephone(),
                                'tax' => $company->tax(),
                                'contactRelation' => $this->includedAdvertisingContact($company->contact()),
                                'addressRelation' => [
                                    'data' => [
                                        'id' => $company->address()->id(),
                                        'street' => $company->address()->street(),
                                        'zip' => $company->address()->zip(),
                                        'city' => $company->address()->city(),
                                        'state' => $company->address()->state(),
                                        'country' => $company->address()->country(),
                                        'longitude' => $company->address()->longitude(),
                                        'latitude' => $company->address()->latitude(),
                                    ]
                                ]
                            ]
                        ]
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
    function it_can_create_an_advertisement()
    {
        $company = $this->createCompleteAdvertisingCompany();
        $now = Carbon::now();
        $end = Carbon::now()->addDays(30);

        $this->post('/api/admin/advertisements', [
            'company_id' => $company->id(),
            'start' => $now->format('d/m/Y'),
            'end' => $end->format('d/m/Y'),
            'amount' => '300',
            'type' => AdObject::RECTANGLE,
            'paid' => true,
            'website' => 'www.equimundo.com',
        ])->seeJsonEquals([
            'data' => [
                'id' => 1,
                'start' => $now->startOfDay()->toIso8601String(),
                'end' => $end->endOfDay()->toIso8601String(),
                'amount' => 300,
                'type' => AdObject::RECTANGLE,
                'paid' => true,
                'clicks' => 0,
                'views' => 0,
                'website' => 'http://www.equimundo.com',
                'companyRelation' => [
                    'data' => [
                        'id' => $company->id(),
                        'name' => $company->name(),
                        'email' => $company->email(),
                        'telephone' => $company->telephone(),
                        'tax' => $company->tax(),
                        'contactRelation' => $this->includedAdvertisingContact($company->contact()),
                        'addressRelation' => [
                            'data' => [
                                'id' => $company->address()->id(),
                                'street' => $company->address()->street(),
                                'zip' => $company->address()->zip(),
                                'city' => $company->address()->city(),
                                'state' => $company->address()->state(),
                                'country' => $company->address()->country(),
                                'longitude' => $company->address()->longitude(),
                                'latitude' => $company->address()->latitude(),
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    function it_can_show_an_advertisement()
    {
        $company = $this->createCompleteAdvertisingCompany();
        $advertisement = $this->createAdvertisement([
            'adv_company_id' => $company->id(),
        ]);

        $this->get('/api/admin/advertisements/' . $advertisement->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => $advertisement->id(),
                    'start' => $advertisement->start()->toIso8601String(),
                    'end' => $advertisement->end()->toIso8601String(),
                    'type' => AdObject::RECTANGLE,
                    'views' => $advertisement->views(),
                    'clicks' => $advertisement->clicks(),
                    'amount' => $advertisement->amount(),
                    'paid' => $advertisement->paid(),
                    'website' => $advertisement->website(),
                    'companyRelation' => [
                        'data' => [
                            'id' => $company->id(),
                            'name' => $company->name(),
                            'email' => $company->email(),
                            'telephone' => $company->telephone(),
                            'tax' => $company->tax(),
                            'contactRelation' => $this->includedAdvertisingContact($company->contact()),
                            'addressRelation' => [
                                'data' => [
                                    'id' => $company->address()->id(),
                                    'street' => $company->address()->street(),
                                    'zip' => $company->address()->zip(),
                                    'city' => $company->address()->city(),
                                    'state' => $company->address()->state(),
                                    'country' => $company->address()->country(),
                                    'longitude' => $company->address()->longitude(),
                                    'latitude' => $company->address()->latitude(),
                                ]
                            ]
                        ]
                    ]
                ],
            ]);
    }

    /** @test */
    function it_can_update_an_advertisement()
    {
        $company = $this->createCompleteAdvertisingCompany();
        $advertisement = $this->createAdvertisement([
            'adv_company_id' => $company->id(),
        ]);

        $this->put('/api/admin/advertisements/' . $advertisement->id(), [
            'amount' => '600',
            'type' => AdObject::FULL_PAGE,
            'paid' => false,
        ])->seeJsonEquals([
                'data' => [
                    'id' => $advertisement->id(),
                    'start' => $advertisement->start()->toIso8601String(),
                    'end' => $advertisement->end()->toIso8601String(),
                    'type' => AdObject::FULL_PAGE,
                    'views' => $advertisement->views(),
                    'clicks' => $advertisement->clicks(),
                    'amount' => 600,
                    'paid' => false,
                    'website' => $advertisement->website(),
                    'companyRelation' => [
                        'data' => [
                            'id' => $company->id(),
                            'name' => $company->name(),
                            'email' => $company->email(),
                            'telephone' => $company->telephone(),
                            'tax' => $company->tax(),
                            'contactRelation' => $this->includedAdvertisingContact($company->contact()),
                            'addressRelation' => [
                                'data' => [
                                    'id' => $company->address()->id(),
                                    'street' => $company->address()->street(),
                                    'zip' => $company->address()->zip(),
                                    'city' => $company->address()->city(),
                                    'state' => $company->address()->state(),
                                    'country' => $company->address()->country(),
                                    'longitude' => $company->address()->longitude(),
                                    'latitude' => $company->address()->latitude(),
                                ]
                            ]
                        ]
                    ]
                ],
            ]);
    }

    /** @test */
    function it_can_delete_an_advertisement()
    {
        $company = $this->createCompleteAdvertisingCompany();
        $advertisement = $this->createAdvertisement([
            'adv_company_id' => $company->id(),
        ]);

        $this->seeInDatabase(Advertisement::TABLE, [
            'id' => $advertisement->id(),
        ]);

        $this->delete('/api/admin/advertisements/' . $advertisement->id())
            ->assertResponseStatus(204);

        $this->missingFromDatabase(Advertisement::TABLE, [
            'id' => $advertisement->id(),
        ]);
    }
}
