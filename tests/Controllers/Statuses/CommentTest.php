<?php
namespace Controllers\Statuses;

use DB;
use EQM\Models\Comments\Comment;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CommentTest extends \TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /** @test */
    function it_can_create_a_comment()
    {
        $user = $this->createUser();
        $horse = $this->createHorse();
        $status = $this->createStatus([
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/statuses/' . $status->id() . '/comments', [
                'body' => 'Foo body'
            ])->assertResponseStatus(302);

        $this->seeInDatabase(Comment::TABLE, [
            'id' => DB::table(Comment::TABLE)->first()->id,
            'body' => 'Foo body',
            'status_id' => $status->id(),
            'user_id' => $user->id(),
        ]);
    }
}
