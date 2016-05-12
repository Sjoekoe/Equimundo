<?php
namespace functional\Api\Conversations;

use Carbon\Carbon;
use DB;
use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Conversations\Message;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConversationsTest extends \TestCase
{
    use DefaultIncludes, DatabaseTransactions;

    /** @test */
    function it_can_get_all_messages_for_a_conversation()
    {
        $user = $this->loginAsUser();
        $conversation = $this->createConversation();
        $message = $this->createMessage([
            'user_id' => $user->id(),
            'conversation_id' => $conversation->id(),
        ]);

        $this->get('/api/conversations/' . $conversation->id() . '/messages')
            ->seeJsonEquals([
                'data' => [
                    $this->includedMessage($message),
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
    function it_can_create_a_message()
    {
        $user = $this->loginAsUser();
        $secondUser = $this->createUser(['email' => 'second@user.com']);
        $conversation = $this->createConversation();
        DB::table('conversation_user')->insert([
            'user_id' => $user->id(),
            'conversation_id' => $conversation->id(),
        ]);
        DB::table('conversation_user')->insert([
            'user_id' => $secondUser->id(),
            'conversation_id' => $conversation->id(),
        ]);

        $this->post('/api/conversations/' . $conversation->id() . '/messages', [
            'body' => 'testing message',
        ])->seeJsonEquals([
            'data' => [
                'id' => DB::table(Message::TABLE)->first()->id,
                'body' => 'testing message',
                'created_at' => Carbon::now()->toIso8601String(),
                'userRelation' => $this->includedUser($user),
                'made_by_user' => true,
                'conversationRelation' => [
                    'data' => $this->includedConversation($conversation),
                ],
            ],
        ]);
    }
}
