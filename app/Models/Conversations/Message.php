<?php
namespace EQM\Models\Conversations;

interface Message
{
    /**
     * @return string
     */
    public function id();

    /**
     * @return string
     */
    public function body();

    /**
     * @return \DateTime
     */
    public function createdAt();

    /**
     * @return \DateTime
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
