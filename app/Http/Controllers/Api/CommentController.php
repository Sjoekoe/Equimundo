<?php
namespace EQM\Http\Controllers\Api;

use EQM\Api\Comments\CommentTransformer;
use EQM\Api\Comments\Requests\PostCommentRequest;
use EQM\Http\Controllers\Controller;
use EQM\Models\Comments\Comment;
use EQM\Models\Comments\CommentRepository;
use EQM\Models\Statuses\Status;
use Input;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

class CommentController extends Controller
{
    /**
     * @var \EQM\Models\Comments\CommentRepository
     */
    private $comments;

    public function __construct(CommentRepository $comments)
    {
        $this->comments = $comments;
    }

    public function index(Status $status)
    {
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $comments = $this->comments->findForStatusPaginated($status, Input::get('limit', 10));
        $comments->getCollection();
        $collection  = new Collection($comments, new CommentTransformer());
        $collection->setPaginator(new IlluminatePaginatorAdapter($comments));
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function store(PostCommentRequest $request, Status $status)
    {
        $comment = $this->comments->create($status, auth()->user(), $request->get('body'));
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $collection  = new Item($comment, new CommentTransformer());
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function show(Status $status, Comment $comment)
    {
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $collection  = new Item($comment, new CommentTransformer());
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function update(PostCommentRequest $request, Status $status, Comment $comment)
    {
        $comment = $this->comments->update($comment, $request->get('body'));
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $collection  = new Item($comment, new CommentTransformer());
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function delete(Status $status, Comment $comment)
    {
        $this->comments->delete($comment);

        return response('', 204);
    }
}
