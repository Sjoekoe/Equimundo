<?php
namespace EQM\Models\Conversations;

interface Message
{
    const TABLE = 'conversation_messages';
    
    /**
     * @return string
     */
    public function id();

    /**
     * @return string
     */
    public function body();

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();

    /**
     * @return \EQM\Models\Conversations\Conversation
     */
    public function conversation();

    /**
     * @return \EQM\Models\Users\User
     */
    public function user();
}
