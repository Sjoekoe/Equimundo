<?php
namespace functional\Api\Wiki;

use DB;
use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Wiki\Topics\Topic;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TopicsTest extends \TestCase
{
    use DefaultIncludes, DatabaseTransactions;

    /** @test */
    function it_can_get_all_topics()
    {
        $topic = $this->createTopic();

        $this->get('/api/topics')
            ->seeJsonEquals([
                'data' => [
                    $this->includedTopic($topic),
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
    function it_can_crete_a_topic()
    {
        $this->post('/api/topics', [
            'title' => 'Test title',
        ])->seeJsonEquals([
            'data' => [
                'id' => DB::table(Topic::TABLE)->first()->id,
                'title' => 'Test title',
            ],
        ]);
    }

    /** @test */
    function it_can_show_a_topic()
    {
        $topic = $this->createTopic();

        $this->get('/api/topics/' . $topic->id())
            ->seeJsonEquals([
                'data' => $this->includedTopic($topic),
            ]);
    }

    /** @test */
    function it_can_update_a_topic()
    {
        $topic = $this->createTopic();

        $this->put('/api/topics/' . $topic->id(), [
            'title' => 'updated-topic',
        ])->seeJsonEquals([
            'data' => $this->includedTopic($topic, [
                'title' => 'updated-topic',
            ]),
        ]);
    }

    /** @test */
    function it_can_delete_a_topic()
    {
        $topic = $this->createTopic();

        $this->seeInDatabase(Topic::TABLE, [
            'id' => $topic->id(),
        ]);

        $this->delete('/api/topics/' . $topic->id())
            ->assertResponseStatus(204);

        $this->missingFromDatabase(Topic::TABLE, [
            'id' => $topic->id(),
        ]);
    }
}
