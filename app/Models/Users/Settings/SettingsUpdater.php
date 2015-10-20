<?php
namespace EQM\Models\Users\Settings;

use EQM\Models\Users\User;

class SettingsUpdater
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param $values
     */
    public function update(User $user, $values)
    {
        if (array_key_exists('email_notifications', $values)) {
            $user->email_notifications = true;
        } else {
            $user->email_notifications = false;
        }

        $user->language = $values['language'];

        $user->save();
    }
}
