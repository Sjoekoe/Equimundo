<?php 
namespace HorseStories\Http\Controllers\Statuses;

use Flash;
use HorseStories\Models\Comments\CommentCreator;
use HorseStories\Models\Statuses\Status;
use Illuminate\Routing\Controller;
use Input;
use Redirect;

class CommentController extends Controller
{
    /**
     * @var \HorseStories\Models\Comments\CommentCreator
     */
    private $commentCreator;

    /**
     * @param \HorseStories\Models\Comments\CommentCreator $commentCreator
     */
    public function __construct(CommentCreator $commentCreator)
    {
        $this->commentCreator = $commentCreator;
    }

    /**
     * @param int $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($status)
    {
        $status = Status::findOrFail($status);

        $this->commentCreator->create($status, Input::get('body'));

        Flash::success('Your comment was posted');

        return response()->json('success', 200);
    }
}