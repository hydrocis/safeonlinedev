<?php

namespace TwoFASLight\User;

use TwoFASLight\Device\TwoFASLight_Trusted_Device;

class TwoFASLight_User
{
    const TWOFAS_LIGHT_TOTP_SECRET = 'twofas_light_totp_secret';
    const TWOFAS_LIGHT_STEP_TOKEN = 'twofas_light_step_token';
    const TWOFAS_LIGHT_TOTP_STATUS = 'twofas_light_totp_status';
    const TWOFAS_LIGHT_TOTP_ENABLED = 'totp_enabled';
    const TWOFAS_LIGHT_TOTP_DISABLED = 'totp_disabled';
    const TWOFAS_LIGHT_TRUSTED_DEVICES = 'twofas_light_trusted_devices';
    const TWOFAS_LIGHT_FAILED_LOGINS_COUNT = 'twofas_light_failed_logins_count';
    const TWOFAS_LIGHT_USER_BLOCKED_UNTIL = 'twofas_light_user_blocked_until';
    
    const TWOFAS_LIGHT_MAX_LOGINS_FAILED = 10;
    const TWOFAS_LIGHT_USER_BLOCK_PERIOD = 300;

    /**
     * @var
     */
    private $id;
    
    /**
     * TwoFASLight_User constructor.
     *
     * @param $wp_user_id
     */
    public function __construct($wp_user_id)
    {
        $this->id = $wp_user_id;
    }

    /**
     * @param $id
     */
    public function set_id($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * @return mixed|null
     */
    public function get_user_trusted_devices()
    {
        return $this->get_user_field(self::TWOFAS_LIGHT_TRUSTED_DEVICES, null);
    }

    /**
     * @param $step_token
     *
     * @return null
     */
    public function get_user_by_step_token($step_token)
    {
        if (!$step_token ||
            !is_string($step_token) ||
            preg_match('/^[a-z0-9]{32}$/', $step_token) !== 1) {
            return null;
        }
        
        $users = get_users(array(
            'meta_key'   => 'twofas_light_step_token',
            'meta_value' => $step_token,
            'fields'     => 'all'
        ));

        if (empty($users) || count($users) !== 1) {
            return null;
        }

        $this->id = $users[0]->ID;
    }

    /**
     * @return bool
     */
    public function has_trusted_device()
    {
        return count($this->get_user_trusted_devices()) > 0;
    }

    /**
     * @return bool
     */
    public function is_blocked()
    {
        $blocked_until = intval($this->get_user_field(self::TWOFAS_LIGHT_USER_BLOCKED_UNTIL, -1));
        
        if ($blocked_until === -1) {
            return false;
        }

        if ($blocked_until < current_time('timestamp', true)) {
            $this->reset_failed_logins_counter();
            return false;
        }
        
        return true;
    }

    public function reset_failed_logins_counter()
    {
        $this->save_user_field(self::TWOFAS_LIGHT_FAILED_LOGINS_COUNT, 0);
        $this->save_user_field(self::TWOFAS_LIGHT_USER_BLOCKED_UNTIL, -1);
    }
    
    public function block_user()
    {
        $this->save_user_field(self::TWOFAS_LIGHT_USER_BLOCKED_UNTIL, current_time('timestamp', true) + self::TWOFAS_LIGHT_USER_BLOCK_PERIOD);
    }

    public function increment_failed_logins_counter()
    {
        $count = $this->get_user_field(self::TWOFAS_LIGHT_FAILED_LOGINS_COUNT, 0);
        $count = $count + 1;
        
        if ($count > self::TWOFAS_LIGHT_MAX_LOGINS_FAILED) {
            $this->block_user();
            return;
        }

        $this->save_user_field(self::TWOFAS_LIGHT_FAILED_LOGINS_COUNT, $count);
    }

    public function remove_trusted_devices()
    {
        $this->save_user_field(self::TWOFAS_LIGHT_TRUSTED_DEVICES, array());
    }

    /**
     * @param $device_id
     *
     * @return bool
     */
    public function remove_trusted_device($device_id)
    {
        $devices = $this->get_user_trusted_devices();

        if ($devices &&
            is_array($devices) &&
            isset($devices[$device_id])) {
            unset($devices[$device_id]);
            $this->save_user_field(self::TWOFAS_LIGHT_TRUSTED_DEVICES, $devices);
            return true;
        }

        return false;
    }

    /**
     * @param TwoFASLight_Trusted_Device $trusted_device
     */
    public function save_user_trusted_device(TwoFASLight_Trusted_Device $trusted_device)
    {
        $devices = $this->get_user_trusted_devices();
        
        $device = array(
            'device_key' => $trusted_device->get_device_key(),
            'ip' => $trusted_device->get_ip(),
            'user_agent' => $trusted_device->get_user_agent(),
            'timestamp' => $trusted_device->get_timestamp()
        );
        
        $devices[$trusted_device->get_device_id()] = $device;
        
        $this->save_user_field(self::TWOFAS_LIGHT_TRUSTED_DEVICES, $devices);
    }

    /**
     * @param      $field_name
     * @param null $default
     *
     * @return mixed|null
     */
    public function get_user_field($field_name, $default=null)
    {
        $result = get_user_meta($this->id, $field_name, true);
        return $result ? $result : $default;
    }

    /**
     * @param $field_name
     * @param $field_value
     */
    public function save_user_field($field_name, $field_value)
    {
        update_user_meta($this->id, $field_name, $field_value);
    }

    /**
     * @return string
     */
    public function get_email()
    {
        return get_userdata($this->id)->user_email;
    }

    /**
     * @param $step_token
     */
    public function set_step_token($step_token)
    {
        update_user_meta($this->id, self::TWOFAS_LIGHT_STEP_TOKEN, $step_token);
    }

    public function enable_totp()
    {
        update_user_meta($this->id, self::TWOFAS_LIGHT_TOTP_STATUS, self::TWOFAS_LIGHT_TOTP_ENABLED);
    }

    /**
     * @return bool
     */
    public function is_totp_configured()
    {
        return get_user_meta($this->id, self::TWOFAS_LIGHT_TOTP_SECRET, true) && true;
    }

    /**
     * @return bool
     */
    public function is_totp_enabled()
    {
        return $this->get_totp_status() === self::TWOFAS_LIGHT_TOTP_ENABLED;
    }

    /**
     * @return mixed
     */
    public function get_totp_status()
    {
        return get_user_meta($this->id, self::TWOFAS_LIGHT_TOTP_STATUS, true);
    }

    public function disable_totp()
    {
        update_user_meta($this->id, self::TWOFAS_LIGHT_TOTP_STATUS, self::TWOFAS_LIGHT_TOTP_DISABLED);
    }

    /**
     * @return mixed
     */
    public function get_totp_secret()
    {
        return get_user_meta($this->id, self::TWOFAS_LIGHT_TOTP_SECRET, true);
    }

    /**
     * @param $totp_secret
     */
    public function set_totp_secret($totp_secret)
    {
        update_user_meta($this->id, self::TWOFAS_LIGHT_TOTP_SECRET, $totp_secret);
    }
}
