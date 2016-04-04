<?php
namespace functional\Api;

class AddressesTest extends \TestCase
{
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
                'id' => 1,
                'street' => 'Foo street',
                'zip' => '1234',
                'city' => 'Antwerp',
                'state' => 'Antwerpen',
                'country' => 'BE',
                'latitude' => 39.1307924,
                'longitude' => 117.1897018,
            ]
        ]);
    }
}
