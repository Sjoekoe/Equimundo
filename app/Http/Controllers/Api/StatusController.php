<?php
namespace EQM\Http\Controllers\Api;

use EQM\Api\Statuses\Requests\StoreStatusRequest;
use EQM\Api\Statuses\Requests\UpdateStatusRequest;
use EQM\Api\Statuses\StatusTransformer;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Statuses\Status;
use EQM\Models\Statuses\StatusRepository;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;

class StatusController extends Controller
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    public function __construct(HorseRepository $horses, StatusRepository $statuses)
    {
        $this->horses = $horses;
        $this->statuses = $statuses;
    }

    public function store(StoreStatusRequest $request)
    {
        $horse = $this->horses->findById($request->get('horse_id'));
        $status = $this->statuses->create($horse, $request->get('body'));
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $collection  = new Item($status, new StatusTransformer());
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function show(Status $status)
    {
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $collection  = new Item($status, new StatusTransformer());
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function update(UpdateStatusRequest $request, Status $status)
    {
        $status = $this->statuses->update($status, $request->all());
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $collection  = new Item($status, new StatusTransformer());
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }

    public function delete(Status $status)
    {
        $this->statuses->delete($status);

        return response('', 204);
    }
}
