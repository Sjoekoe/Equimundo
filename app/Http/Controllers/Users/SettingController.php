<?php
namespace EQM\Http\Controllers\Users;

use EQM\Models\Users\Settings\SettingsUpdater;
use Illuminate\Routing\Controller;
use Input;

class SettingController extends Controller
{
    /**
     * @var \EQM\Models\Users\Settings\SettingsUpdater
     */
    private $updater;

    /**
     * @param \EQM\Models\Users\Settings\SettingsUpdater $updater
     */
    public function __construct(SettingsUpdater $updater)
    {
        $this->updater = $updater;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('users.settings.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $this->updater->update(auth()->user(), Input::all());

        return back();
    }
}
