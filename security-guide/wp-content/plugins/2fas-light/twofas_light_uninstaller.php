<?php

class TwoFASLight_Uninstaller
{
    public function uninstall()
    {
        $this->clear_wp_usermeta();
        $this->clear_wp_options();
    }

    private function clear_wp_usermeta()
    {
        $user_meta = array(
            'twofas_light_totp_secret',
            'twofas_light_totp_status',
            'twofas_light_trusted_devices',
            'twofas_light_step_token',
            'twofas_light_failed_logins_count',
            'twofas_light_user_blocked_until',
        );

        $users = get_users();

        foreach ($users as $user) {
            foreach ($user_meta as $meta_key) {
                delete_user_meta($user->ID, $meta_key);
            }
        }
    }

    private function clear_wp_options()
    {
        delete_option('twofas_light_plugin_version');
    }
}
