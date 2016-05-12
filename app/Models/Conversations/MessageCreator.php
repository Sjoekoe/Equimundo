<?php
namespace EQM\Models\Conversations;

use EQM\Core\Database\CanMakeDatabaseTransactions;
use EQM\Core\Database\TransactionManager;
use EQM\Models\Users\User;
use Illuminate\Http\Request;

class MessageCreator
{
    use CanMakeDatabaseTransactions;

    /**
     * @var \EQM\Models\Conversations\MessageRepository
     */
    private $messages;

    public function __construct(TransactionManager $transactionManager, MessageRepository $messages)
    {
        $this->transactionManager = $transactionManager;
        $this->messages = $messages;
    }

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @param \EQM\Models\Users\User $user
     * @param \Illuminate\Http\Request $request
     * @return \EQM\Models\Conversations\Message
     */
    public function create(Conversation $conversation, User $user, Request $request)
    {
        return $this->transaction(function() use ($conversation, $user, $request) {
            $message = $this->messages->create($conversation, $user, $request->all());

            $conversation->markAsUnread($conversation->contactPerson($user));

            if ($conversation->isDeletedForContactPerson($user)) {
                $conversation->unDeleteForContactPerson($user);
            }

            return $message;
        });

    }
}
