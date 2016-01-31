<?php
namespace EQM\Http\Controllers\Users;

use EQM\Models\Users\Settings\SettingsUpdater;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Input;

class SettingController extends Controller
{
    public function index()
    {
        return view('users.settings.index');
    }

    public function update(Request $request, SettingsUpdater $updater)
    {
        $updater->update(auth()->user(), $request);

        session()->put('success', 'Settings saved');

        return back();
    }
}
