<?php
namespace EQM\Http\Controllers\Statuses;

use Auth;
use EQM\Http\Requests\PostStatus;
use EQM\Models\Statuses\StatusCreator;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Statuses\StatusUpdater;
use Illuminate\Routing\Controller;
use Input;
use Session;

class StatusController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusCreator
     */
    private $statusCreator;

    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\Statuses\StatusUpdater
     */
    private $updater;

    /**
     * @param \EQM\Models\Statuses\StatusCreator $statusCreator
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\Statuses\StatusUpdater $updater
     */
    public function __construct(StatusCreator $statusCreator, StatusRepository $statuses, StatusUpdater $updater)
    {
        $this->statusCreator = $statusCreator;
        $this->statuses = $statuses;
        $this->updater = $updater;
    }

    /**
     * @param \EQM\Http\Requests\PostStatus $request
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
     * @param \EQM\Http\Requests\PostStatus $request
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
     * @return \EQM\Models\Statuses\Status
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
