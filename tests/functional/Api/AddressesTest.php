<?php
namespace functional\Api;

use DB;
use EQM\Models\Addresses\Address;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddressesTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test */
    function it_can_create_an_address()
    {
        $this->post('/api/addresses', [
            'street' => 'Foo street',
            'zip' => '1234',
            'city' => 'Antwerp',
            'state' => 'Antwerpen',
            'country' => 'BE',
        ])->seeJsonEquals([
            'data' => [
                'id' => DB::table(Address::TABLE)->first()->id,
                'street' => 'Foo street',
                'zip' => '1234',
                'city' => 'Antwerp',
                'state' => 'Antwerpen',
                'country' => 'BE',
                'latitude' => 49.577943,
                'longitude' => 10.9070102,
            ]
        ]);
    }
}
