<?php
namespace EQM\Http\Controllers\Users;

use EQM\Http\Controllers\Controller;
use EQM\Models\Users\Requests\UpdateUserProfile;
use EQM\Models\Users\User;
use EQM\Models\Users\UserRepository;

class ProfileController extends  Controller
{
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function edit()
    {
        return view('users.profiles.edit');
    }

    public function update(UpdateUserProfile $request)
    {
        $this->users->update(auth()->user(), $request->all());

        session()->put('success', 'Profile was updated');

        return redirect()->route('users.profiles.edit');
    }

    public function show(User $user)
    {
        return view('users.profiles.show', compact('user'));
    }

    public function delete()
    {
        $user = auth()->user();

        auth()->logout();

        $this->users->delete($user);

        return redirect()->route('home');
    }
}
