<?php
namespace EQM\Http\Controllers\Admin;

use Carbon\Carbon;
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
        $users = $this->users->paginated(30);
        $usersRegistered = $this->collectUserData();
        $userGrowth = $this->getUserGrowth();

        return view('admin.users.index', compact('users', 'usersRegistered', 'userGrowth'));
    }

    private function collectUserData()
    {
        $month = 30;
        $result = [];

        for ($i = $month; $i >= 0; $i--) {
            $date = Carbon::now()->subDay($i);
            $start = Carbon::now()->subDay($i)->startOfDay();
            $end = Carbon::now()->subDay($i)->endOfDay();
            $count = $this->users->findCountByDate($start, $end);

            $result[] = [
                'date' => $date->format('Y-m-d'),
                'users' => $count
            ];
        }

        return $result;
    }

    private function getUserGrowth()
    {
        $month = 30;
        $result = [];

        for ($i = $month; $i >= 0; $i--) {
            $date = Carbon::now()->subDay($i);
            $end = Carbon::now()->subDay($i)->endOfDay();
            $count = $this->users->findRegisteredUsersBeforeDate($end);

            $result[] = [
                'date' => $date->format('Y-m-d'),
                'users' => $count
            ];
        }

        return $result;
    }
}
