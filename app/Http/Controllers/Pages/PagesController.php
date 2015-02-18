<?php 
namespace HorseStories\Http\Controllers\Pages;

use Auth;
use HorseStories\Http\Controllers\Controller;
use HorseStories\Models\Users\UserRepository;

class PagesController extends Controller
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

    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        if (Auth::check()) {
            $horses = $this->users->findHorsesForSelect(Auth::user());
        }

        return view('pages.home', compact('horses'));
    }
}