<?php
namespace EQM\Api\Http\Controllers\Wiki;

use EQM\Api\Http\Controller;
use EQM\Api\Wiki\Topics\Requests\StoreTopicRequest;
use EQM\Api\Wiki\Topics\Requests\UpdateTopicRequest;
use EQM\Api\Wiki\Topics\TopicTransformer;
use EQM\Models\Wiki\Topics\Topic;
use EQM\Models\Wiki\Topics\TopicRepository;

class TopicController extends Controller
{
    /**
     * @var \EQM\Models\Wiki\Topics\TopicRepository
     */
    private $topics;

    public function __construct(TopicRepository $topics)
    {
        $this->topics = $topics;
    }

    public function index()
    {
        $topics = $this->topics->findAllPaginated();

        return $this->response()->paginator($topics, new TopicTransformer());
    }

    public function store(StoreTopicRequest $request)
    {
        $topic = $this->topics->create($request->all());

        return $this->response()->item($topic, new TopicTransformer());
    }

    public function show(Topic $topic)
    {
        return $this->response()->item($topic, new TopicTransformer());
    }

    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $topic = $this->topics->update($topic, $request->all());

        return $this->response()->item($topic, new TopicTransformer());
    }

    public function delete(Topic $topic)
    {
        $this->topics->delete($topic);

        return $this->response()->noContent();
    }
}
