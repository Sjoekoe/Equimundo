<?php
namespace EQM\Http\Controllers\Statuses;

use Auth;
use EQM\Core\Files\Uploader;
use EQM\Http\Requests\PostStatus;
use EQM\Models\Albums\Album;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Statuses\StatusRepository;
use Illuminate\Routing\Controller;
use Input;
use Session;

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
     * @param \EQM\Http\Requests\PostStatus $request
     * @return string
     */
    public function store(PostStatus $request)
    {
        $status = $this->statuses->create($request->all());

        if (array_key_exists('picture', $request->all())) {
            $horse = $this->horses->findById($request->get('horse'));
            $picture = $this->uploader->uploadPicture($request->get('picture'), $horse);

            $picture->addToAlbum($horse->getStandardAlbum(Album::TIMELINEPICTURES));
            $status->setPicture($picture);

            $status->save();
        }

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

        if ($status->user()->id == Auth::user()->id) {
            return $status;
        }

        abort(403);
    }
}
