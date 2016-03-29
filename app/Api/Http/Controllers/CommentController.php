<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Comments\CommentTransformer;
use EQM\Api\Comments\Requests\PostCommentRequest;
use EQM\Api\Http\Controller;
use EQM\Models\Comments\Comment;
use EQM\Models\Comments\CommentCreator;
use EQM\Models\Comments\CommentRepository;
use EQM\Models\Statuses\Status;
use Input;

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
        $comments = $this->comments->findForStatusPaginated($status, Input::get('limit', 10));

        return $this->response()->paginator($comments, new CommentTransformer());
    }

    public function store(PostCommentRequest $request, CommentCreator $creator, Status $status)
    {
        $comment = $creator->create($status, auth()->user(), $request);

        return $this->response()->item($comment, new CommentTransformer());
    }

    public function show(Status $status, Comment $comment)
    {
        return $this->response()->item($comment, new CommentTransformer());
    }

    public function update(PostCommentRequest $request, Status $status, Comment $comment)
    {
        $comment = $this->comments->update($comment, $request->get('body'));

        return $this->response()->item($comment, new CommentTransformer());
    }

    public function delete(Status $status, Comment $comment)
    {
        $this->comments->delete($comment);

        return $this->response()->noContent();
    }
}
