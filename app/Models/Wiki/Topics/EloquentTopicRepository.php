<?php
namespace EQM\Models\Wiki\Topics;

class EloquentTopicRepository implements TopicRepository
{
    /**
     * @var \EQM\Models\Wiki\Topics\EloquentTopic
     */
    private $topic;

    public function __construct(EloquentTopic $topic)
    {
        $this->topic = $topic;
    }

    /**
     * @param array $values
     * @return \EQM\Models\Wiki\Topics\Topic
     */
    public function create(array $values)
    {
        $topic = new EloquentTopic($values);

        $topic->save();

        return $topic;
    }

    /**
     * @param \EQM\Models\Wiki\Topics\Topic $topic
     * @param array $values
     * @return \EQM\Models\Wiki\Topics\Topic
     */
    public function update(Topic $topic, array $values)
    {
        if (array_key_exists('title', $values)) {
            $topic->title = $values['title'];
        }

        $topic->save();

        return $topic;
    }

    /**
     * @param \EQM\Models\Wiki\Topics\Topic $topic
     */
    public function delete(Topic $topic)
    {
        $topic->delete();
    }

    /**
     * @param int $id
     * @return \EQM\Models\Wiki\Topics\Topic|null
     */
    public function find($id)
    {
        return $this->topic->where('id', $id)->first();
    }

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllPaginated($limit = 50)
    {
        return $this->topic->paginate($limit);
    }
}
