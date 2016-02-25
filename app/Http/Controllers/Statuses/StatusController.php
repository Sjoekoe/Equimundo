<?php
namespace EQM\Http\Controllers\Statuses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Statuses\Likes\LikeRepository;
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
     * @var \EQM\Models\Statuses\Likes\LikeRepository
     */
    private $likes;

    public function __construct(StatusRepository $statuses, LikeRepository $likes)
    {
        $this->statuses = $statuses;
        $this->likes = $likes;
    }

    public function store(PostStatus $request, StatusCreator $creator)
    {
        ini_set('upload_max_filesize', '350MB');
        ini_set('post_max_size', '10M');

        $creator->create($request->all());

        session()->put('success', 'Status has been posted');

        return redirect()->route('home');
    }

	public function show(Status $status)
	{
		$likes = $this->likes->findForUser(auth()->user());
		return view('statuses.show', compact('status', 'likes'));
	}

    public function edit(Status $status)
    {
        $this->authorize('edit-status', $status);

        return view('statuses.edit', compact('status'));
    }

    public function update(PostStatus $request, Status $status)
    {
        $this->authorize('edit-status', $status);

        $this->statuses->update($status, $request->all());

        return redirect()->route('home');
    }

    public function delete(Status $status)
    {
        $this->authorize('delete-status', $status);

        $status->delete();

        return redirect()->back();
    }
}
