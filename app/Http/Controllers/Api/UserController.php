<?php
namespace EQM\Http\Controllers\Api;

use EQM\Api\Statuses\StatusTransformer;
use EQM\Http\Controllers\Controller;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\User;
use Input;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;

class UserController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    public function __construct(StatusRepository $statuses)
    {
        $this->statuses = $statuses;
    }

    public function feed(User $user)
    {
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $statuses = $this->statuses->findFeedForUserPaginated($user, Input::get('limit', 10));
        $statuses->getCollection();
        $collection  = new Collection($statuses, new StatusTransformer());
        $collection->setPaginator(new IlluminatePaginatorAdapter($statuses));
        $result = $manager->createData($collection)->toArray();

        return response($result);
    }
}
