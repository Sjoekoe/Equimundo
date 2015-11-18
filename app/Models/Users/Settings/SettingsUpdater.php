<?php
namespace EQM\Models\Users\Settings;

use EQM\Models\Users\User;
use Illuminate\Http\Request;

class SettingsUpdater
{
    /**
     * todo move this to the user repository
     *
     * @param \EQM\Models\Users\User $user
     * @param \Illuminate\Http\Request $request
     */
    public function update(User $user, Request $request)
    {
        if (array_key_exists('email_notifications', $request->all())) {
            $user->email_notifications = true;
        } else {
            $user->email_notifications = false;
        }

        $user->language = $request->get('language');

        $user->save();
    }
}
