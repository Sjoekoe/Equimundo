<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Http\Controller;
use EQM\Api\Statuses\StatusTransformer;
use EQM\Api\Users\UserTransformer;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\User;
use EQM\Models\Users\UserRepository;
use Illuminate\Http\Request;
use Input;

class UserController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    public function __construct(StatusRepository $statuses, UserRepository $users)
    {
        $this->statuses = $statuses;
        $this->users = $users;
    }

    public function show(User $user)
    {
        return $this->response()->item($user, new UserTransformer());
    }

    public function update(Request $request, User $user)
    {
        $user = $this->users->update($user, $request->all());

        return $this->response()->item($user, new UserTransformer());
    }

    public function feed(User $user)
    {
        $statuses = $this->statuses->findFeedForUserPaginated($user, Input::get('limit', 10));

        return $this->response()->paginator($statuses, new StatusTransformer());
    }
}
