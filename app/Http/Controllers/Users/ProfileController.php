<?php
namespace EQM\Http\Controllers\Users;

use EQM\Http\Controllers\Controller;
use EQM\Http\Requests\UpdateUserProfile;
use EQM\Models\Users\User;
use EQM\Models\Users\UserRepository;

class ProfileController extends  Controller
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
    public function edit()
    {
        return view('users.profiles.edit');
    }

    /**
     * @param \EQM\Http\Requests\UpdateUserProfile $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserProfile $request)
    {
        $user = $this->users->findById(auth()->user()->id);

        $this->users->update($user, $request->all());

        session()->put('success', 'Profile was updated');

        return redirect()->route('users.profiles.edit');
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.profiles.show', compact('user'));
    }
}
