<?php 
namespace HorseStories\Http\Controllers\Users;

use Auth;
use Flash;
use HorseStories\Http\Controllers\Controller;
use HorseStories\Http\Requests\UpdateUserProfile;
use HorseStories\Models\Users\User;

class ProfileController extends  Controller
{
    public function edit()
    {
        return view('users.profiles.edit');
    }

    public function update(UpdateUserProfile $request)
    {
        $user = User::find(Auth::user()->id);

        $user->update($request->all());

        Flash::success('Profile was updated');

        return back();
    }
}