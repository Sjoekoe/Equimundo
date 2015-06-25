<?php
namespace HorseStories\Http\Controllers\Admin;

use HorseStories\Models\Users\UserRepository;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    /**
     * @var \HorseStories\Models\Users\UserRepository
     */
    private $users;

    /**
     * @param \HorseStories\Models\Users\UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        $users = $this->users->all();

        return view('admin.users.index', compact('users'));
    }
}
