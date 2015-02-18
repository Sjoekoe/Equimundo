<?php 
namespace HorseStories\Http\Controllers\Statuses;
  
use HorseStories\Http\Requests\PostStatus;
use HorseStories\Models\Statuses\StatusCreator;
use Illuminate\Routing\Controller;
use Laracasts\Flash\Flash;

class StatusController extends Controller
{
    /**
     * @var \HorseStories\Models\Statuses\StatusCreator
     */
    private $statusCreator;

    public function __construct(StatusCreator $statusCreator)
    {
        $this->statusCreator = $statusCreator;
    }

    /**
     * @param \HorseStories\Http\Requests\PostStatus $request
     * @return string
     */
    public function store(PostStatus $request)
    {
        $this->statusCreator->create($request->all());

        Flash::success('Status has been posted');

        return redirect()->refresh();
    }
}