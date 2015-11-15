<?php
namespace EQM\Models\Users\Settings;

use EQM\Http\Requests\Request;
use EQM\Models\Users\User;

class SettingsUpdater
{
    /**
     * todo move this to the user repository
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Http\Requests\Request $request
     * @internal param $values
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
