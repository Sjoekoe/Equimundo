<?php
namespace EQM\Http\Controllers\Statuses;

use EQM\Core\Files\Uploader;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Statuses\Requests\PostStatus;
use EQM\Models\Statuses\StatusCreator;
use EQM\Models\Statuses\StatusRepository;
use Illuminate\Routing\Controller;

class StatusController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Core\Files\Uploader $uploader
     */
    public function __construct(StatusRepository $statuses, HorseRepository $horses, Uploader $uploader)
    {
        $this->statuses = $statuses;
        $this->horses = $horses;
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
     * @param \EQM\Models\Statuses\Requests\PostStatus $request
     * @param int $statusId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostStatus $request, $statusId)
    {
        $status = $this->initStatus($statusId);

        $this->statuses->update($status, $request->all());

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

        if (auth()->user()->isInHorseTeam($status->horse())) {
            return $status;
        }

        abort(403);
    }
}
