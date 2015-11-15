<?php
namespace EQM\Http\Controllers\Users;

use EQM\Models\Users\Settings\SettingsUpdater;
use Illuminate\Routing\Controller;
use Input;

class SettingController extends Controller
{
    public function index()
    {
        return view('users.settings.index');
    }

    public function update(SettingsUpdater $updater)
    {
        $updater->update(auth()->user(), Input::all());

        return back();
    }
}
