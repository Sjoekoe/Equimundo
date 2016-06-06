<?php
namespace functional\Api\Wiki;

use DB;
use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Wiki\Articles\Article;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticlesTest extends \TestCase
{
    use DefaultIncludes, DatabaseTransactions;

    /** @test */
    function it_can_show_all_articles()
    {
        $topic = $this->createTopic();
        $article = $this->createArticle([
            'topic_id' => $topic->id(),
        ]);

        $this->get('/api/topics/' . $topic->id() . '/articles')
            ->seeJsonEquals([
                'data' => [
                    $this->includedArticle($article),
                ],
                'meta' => [
                    'pagination' => [
                        'count' => 1,
                        'current_page' => 1,
                        'links' => [],
                        'per_page' => 50,
                        'total' => 1,
                        'total_pages' => 1,
                    ],
                ]
            ]);
    }

    /** @test */
    function it_can_create_an_article()
    {
        $topic = $this->createTopic();

        $this->post('/api/topics/' . $topic->id() . '/articles', [
            'title' => 'store article',
            'body' => 'This is a test body',
        ])->seeJsonEquals([
            'data' => [
                'id' => DB::table(Article::TABLE)->first()->id,
                'title' => 'store article',
                'slug' => 'store-article',
                'body' => 'This is a test body',
                'views' => 0,
                'topicRelation' => [
                    'data' => $this->includedTopic($topic),
                ],
            ],
        ]);
    }

    /** @test */
    function it_can_show_an_article()
    {
        $topic = $this->createTopic();
        $article = $this->createArticle([
            'topic_id' => $topic->id(),
        ]);

        $this->get('/api/topics/' . $topic->id() . '/articles/' . $article->slug())
            ->seeJsonEquals([
                'data' => $this->includedArticle($article),
            ]);
    }

    /** @test */
    function it_can_update_an_article()
    {
        $topic = $this->createTopic();
        $article = $this->createArticle([
            'topic_id' => $topic->id(),
        ]);

        $this->put('/api/topics/' . $topic->id() . '/articles/' . $article->slug(), [
            'title' => 'Updated article',
            'body' => 'updated body',
        ])->seeJsonEquals([
            'data' => $this->includedArticle($article, [
                'title' => 'Updated article',
                'slug' => 'updated-article',
                'body' => 'updated body',
            ]),
        ]);
    }

    /** @test */
    function it_can_delete_an_article()
    {
        $topic = $this->createTopic();
        $article = $this->createArticle([
            'topic_id' => $topic->id(),
        ]);

        $this->seeInDatabase(Article::TABLE, [
            'id' => $article->id(),
        ]);

        $this->delete('/api/topics/' . $topic->id() . '/articles/' . $article->slug())
            ->assertNoContent();

        $this->missingFromDatabase(Article::TABLE, [
            'id' => $article->id(),
        ]);
    }
}
