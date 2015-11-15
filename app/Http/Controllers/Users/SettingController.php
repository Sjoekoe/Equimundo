<?php
namespace EQM\Http\Controllers\Users;

use EQM\Http\Requests\Request;
use EQM\Models\Users\Settings\SettingsUpdater;
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

        return back();
    }
}
