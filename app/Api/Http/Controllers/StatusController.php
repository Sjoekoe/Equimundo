<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Http\Controller;
use EQM\Api\Statuses\Requests\StoreStatusRequest;
use EQM\Api\Statuses\Requests\UpdateStatusRequest;
use EQM\Api\Statuses\StatusTransformer;
use EQM\Models\Statuses\Status;
use EQM\Models\Statuses\StatusCreator;
use EQM\Models\Statuses\StatusRepository;

class StatusController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    public function __construct(StatusRepository $statuses)
    {
        $this->statuses = $statuses;
    }

    public function store(StoreStatusRequest $request, StatusCreator $creator)
    {
        $status = $creator->create($request->all());

        return $this->response()->item($status, new StatusTransformer());
    }

    public function show(Status $status)
    {
        return $this->response()->item($status, new StatusTransformer());
    }

    public function update(UpdateStatusRequest $request, Status $status)
    {
        $status = $this->statuses->update($status, $request->all());

        return $this->response()->item($status, new StatusTransformer());
    }

    public function delete(Status $status)
    {
        $this->statuses->delete($status);

        return $this->response()->noContent();
    }
}
