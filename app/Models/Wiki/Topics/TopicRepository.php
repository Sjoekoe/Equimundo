<?php
namespace EQM\Models\Wiki\Topics;

interface TopicRepository
{
    /**
     * @param array $values
     * @return \EQM\Models\Wiki\Topics\Topic
     */
    public function create(array $values);

    /**
     * @param \EQM\Models\Wiki\Topics\Topic $topic
     * @param array $values
     * @return \EQM\Models\Wiki\Topics\Topic
     */
    public function update(Topic $topic, array $values);

    /**
     * @param \EQM\Models\Wiki\Topics\Topic $topic
     */
    public function delete(Topic $topic);

    /**
     * @param int $id
     * @return \EQM\Models\Wiki\Topics\Topic|null
     */
    public function find($id);

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllPaginated($limit = 50);
}
