<?php
namespace functional\Search;

use EQM\Events\SearchWasPerformed;
use EQM\Models\Searches\Search;

class SearchTest extends \TestCase
{
    /** @test */
    function it_can_search_for_users()
    {
        $user = $this->createUser();

        $this->withoutMiddleware()
            ->post('search', [
            'search' => $user->firstName(),
        ]);

        $this->assertResponseStatus(302);
    }

    /** @test */
    function it_can_search_for_horses()
    {
        $horse = $this->createHorse();

        $this->withoutMiddleware()
            ->post('search', [
                'search' => $horse->name(),
            ]);

        $this->assertResponseStatus(302);
    }

    // todo fix this test
    function it_sees_a_record_of_the_search()
    {
        $this->withoutEvents();
        $horse = $this->createHorse();

        $this->withoutMiddleware()
            ->post('search', [
                'search' => $horse->name(),
            ]);

        $this->assertResponseStatus(302);

        $this->seeInDatabase(Search::TABLE, [
            'term' => $horse->name(),
            'count' => 1,
        ]);
    }
}
