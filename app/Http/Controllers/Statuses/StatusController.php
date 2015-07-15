<?php
namespace HorseStories\Http\Controllers\Statuses;

use Auth;
use HorseStories\Http\Requests\PostStatus;
use HorseStories\Models\Statuses\StatusCreator;
use HorseStories\Models\Statuses\StatusRepository;
use HorseStories\Models\Statuses\StatusUpdater;
use Illuminate\Routing\Controller;
use Input;
use Session;

class StatusController extends Controller
{
    /**
     * @var \HorseStories\Models\Statuses\StatusCreator
     */
    private $statusCreator;

    /**
     * @var \HorseStories\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \HorseStories\Models\Statuses\StatusUpdater
     */
    private $updater;

    /**
     * @param \HorseStories\Models\Statuses\StatusCreator $statusCreator
     * @param \HorseStories\Models\Statuses\StatusRepository $statuses
     * @param \HorseStories\Models\Statuses\StatusUpdater $updater
     */
    public function __construct(StatusCreator $statusCreator, StatusRepository $statuses, StatusUpdater $updater)
    {
        $this->statusCreator = $statusCreator;
        $this->statuses = $statuses;
        $this->updater = $updater;
    }

    /**
     * @param \HorseStories\Http\Requests\PostStatus $request
     * @return string
     */
    public function store(PostStatus $request)
    {
        $this->statusCreator->create($request->all());

        Session::put('success', 'Status has been posted');

        return redirect()->refresh();
    }

    public function show($statusId)
    {
        $status = $this->statuses->findById($statusId);

        return view('statuses.show', compact('status'));
    }

    /**
     * @param int $statusId
     * @return \Illuminate\View\View
     */
    public function edit($statusId)
    {
        $status = $this->initStatus($statusId);

        return view('statuses.edit', compact('status'));
    }

    /**
     * @param int $statusId
     * @param \HorseStories\Http\Requests\PostStatus $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($statusId, PostStatus $request)
    {
        $status = $this->initStatus($statusId);

        $this->updater->update($status, $request->all());

        return redirect()->route('home');
    }

    /**
     * @param int $statusId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($statusId)
    {
        $status = $this->initStatus($statusId);

        $status->delete();

        return redirect()->back();
    }

    /**
     * @param int $statusId
     * @return \HorseStories\Models\Statuses\Status
     */
    private function initStatus($statusId)
    {
        $status = $this->statuses->findById($statusId);

        if ($status->user()->id == Auth::user()->id) {
            return $status;
        }

        abort(403);
    }
}
