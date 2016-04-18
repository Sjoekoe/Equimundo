<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Http\Controller;
use EQM\Api\Statuses\HorseStatusTransformer;
use EQM\Api\Statuses\StatusTransformer;
use EQM\Api\Users\UserTransformer;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\User;
use Input;

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

    public function show(User $user)
    {
        return $this->response()->item($user, new UserTransformer());
    }

    public function feed(User $user)
    {
        $statuses = $this->statuses->findFeedForUserPaginated($user, Input::get('limit', 10));

        return $this->response()->paginator($statuses, new HorseStatusTransformer());
    }
}
