<?php
namespace EQM\Http\Controllers\Statuses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Comments\Comment;
use EQM\Models\Comments\CommentCreator;
use EQM\Models\Comments\CommentRepository;
use EQM\Models\Statuses\Status;
use Illuminate\Http\Request;

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

    //todo add validation
    public function store(Request $request, CommentCreator $creator, Status $status)
    {
        $creator->create($status, auth()->user(), $request);

        session()->put('success', 'Your comment was posted');

        return response()->json('success', 200);
    }

    public function edit(Comment $comment)
    {
        $this->authorize('edit-comment', $comment);

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('edit-comment', $comment);

        $this->comments->update($comment, $request->get('body'));

        session()->put('success', 'Your comment was edited.');

        return redirect()->route('home');
    }

    public function delete(Comment $comment)
    {
        $this->authorize('delete-comment', $comment);

        $this->comments->delete($comment);

        session()->put('success', 'comment deleted');

        return back();
    }
}
