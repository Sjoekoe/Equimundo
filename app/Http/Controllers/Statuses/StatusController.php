<?php
namespace EQM\Http\Controllers\Statuses;

use EQM\Core\Files\Uploader;
use EQM\Http\Controllers\Controller;
use EQM\Models\Statuses\Requests\PostStatus;
use EQM\Models\Statuses\Status;
use EQM\Models\Statuses\StatusCreator;
use EQM\Models\Statuses\StatusRepository;

class StatusController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Core\Files\Uploader $uploader
     */
    public function __construct(StatusRepository $statuses, Uploader $uploader)
    {
        $this->statuses = $statuses;
        $this->uploader = $uploader;
    }

    /**
     * @param \EQM\Models\Statuses\Requests\PostStatus $request
     * @param \EQM\Models\Statuses\StatusCreator $creator
     * @return string
     */
    public function store(PostStatus $request, StatusCreator $creator)
    {
        $creator->create($request->all());

        session()->put('success', 'Status has been posted');

        return redirect()->refresh();
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @return \Illuminate\View\View
     */
    public function show(Status $status)
    {
        return view('statuses.show', compact('status'));
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @return \Illuminate\View\View
     */
    public function edit(Status $status)
    {
        $this->authorize('edit-status', $status);

        return view('statuses.edit', compact('status'));
    }

    /**
     * @param \EQM\Models\Statuses\Requests\PostStatus $request
     * @param \EQM\Models\Statuses\Status $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostStatus $request, Status $status)
    {
        $this->authorize('edit-status', $status);

        $this->statuses->update($status, $request->all());

        return redirect()->route('home');
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Status $status)
    {
        $this->authorize('delete-status', $status);

        $status->delete();

        return redirect()->back();
    }
}
