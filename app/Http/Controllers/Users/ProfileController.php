<?php
namespace HorseStories\Http\Controllers\Users;

use Auth;
use HorseStories\Http\Controllers\Controller;
use HorseStories\Http\Requests\UpdateUserProfile;
use HorseStories\Models\Users\UserRepository;
use Session;

class ProfileController extends  Controller
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
    public function edit()
    {
        return view('users.profiles.edit');
    }

    /**
     * @param \HorseStories\Http\Requests\UpdateUserProfile $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserProfile $request)
    {
        $user = $this->users->findById(Auth::user()->id);

        $user->update($request->all());

        Session::put('success', 'Profile was updated');

        return back();
    }

    /**
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function show($userId)
    {
        $user = $this->users->findById($userId);

        return view('users.profiles.show', compact('user'));
    }
}
