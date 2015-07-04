<?php
namespace HorseStories\Models\Settings;

class SettingsUpdater
{
    public function update(Setting $setting, $values)
    {
        if (array_key_exists('email_notifications', $values)) {
            $setting->email_notifications = $values['email_notifications'];
        } else {
            $setting->email_notifications = false;
        }

        $setting->language = $values['language'];

        $setting->save();
    }
}
