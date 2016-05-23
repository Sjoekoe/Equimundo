<?php
namespace EQM\Api\Wiki\Topics;

use EQM\Models\Wiki\Topics\Topic;
use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract
{
    /**
     * @param \EQM\Models\Wiki\Topics\Topic $topic
     * @return array
     */
    public function transform(Topic $topic)
    {
        return [
            'id' => $topic->id(),
            'title' => $topic->title(),
        ];
    }
}
