<?php
namespace EQM\Models\Conversations;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class ConversationRouteBinder extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Conversations\ConversationRepository
     */
    private $conversations;

    /**
     * @param \EQM\Models\Conversations\ConversationRepository $conversations
     */
    public function __construct(ConversationRepository $conversations)
    {
        $this->conversations = $conversations;
    }

    /**
     * @param int|string $slug
     * @return mixed
     */
    public function find($slug)
    {
        return $this->conversations->findById($slug);
    }
}
