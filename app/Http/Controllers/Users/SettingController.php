<?php
namespace EQM\Http\Controllers\Users;

use EQM\Models\Settings\SettingsUpdater;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use Input;
use Redirect;

class SettingController extends Controller
{
    /**
     * @var \EQM\Models\Settings\SettingsUpdater
     */
    private $updater;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @param \EQM\Models\Settings\SettingsUpdater $updater
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct(SettingsUpdater $updater, AuthManager $auth)
    {
        $this->auth = $auth;
        $this->updater = $updater;
    }

    public function index()
    {
        return view('users.settings.index');
    }

    public function update()
    {
        $this->updater->update($this->auth->user()->settings, Input::all());

        return Redirect::back();
    }
}
