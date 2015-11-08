<?php
namespace EQM\Http\Controllers\Admin;

use EQM\Models\Users\UserRepository;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @param \EQM\Models\Users\UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->users->all();

        return view('admin.users.index', compact('users'));
    }
}
