<?php

namespace TwoFASLight\Device;

use TwoFASLight\Cookie\TwoFASLight_Cookie;
use TwoFASLight\Request\TwoFASLight_Request;
use TwoFASLight\User\TwoFASLight_User;

class TwoFASLight_Trusted_Device
{
    /**
     * @var string
     */
    const TWOFASLIGHT_COOKIE_TRUSTED_DEVICE_LIFESPAN = 2147483647;
    
    /**
     * @var null
     */
    private $ip;

    /**
     * @var null
     */
    private $user_agent;

    /**
     * @var int|string
     */
    private $timestamp;

    /**
     * @var TwoFASLight_User
     */
    private $user;

    /**
     * @var TwoFASLight_Request
     */
    private $request;

    /**
     * @var TwoFASLight_Cookie
     */
    private $cookie;

    /**
     * @var bool
     */
    private $is_device_trusted = false;

    /**
     * @var null
     */
    private $device_key = null;

    /**
     * @var null
     */
    private $device_id = null;


    /**
     * TwoFASLight_Trusted_Device constructor.
     *
     * @param TwoFASLight_Request $request
     * @param TwoFASLight_User    $user
     * @param TwoFASLight_Cookie  $cookie
     */
    public function __construct(TwoFASLight_Request $request, TwoFASLight_User $user, TwoFASLight_Cookie $cookie)
    {
        $this->ip = $request->get_ip();
        $this->user_agent = $request->get_user_agent();
        $this->timestamp = $request->get_timestamp();
        $this->user = $user;
        $this->request = $request;
        $this->cookie = $cookie;
    }

    /**
     * @return null
     */
    public function get_device_id()
    {
        return $this->device_id;
    }

    /**
     * @return null
     */
    public function get_device_key()
    {
        return $this->device_key;
    }

    /**
     * @return null
     */
    public function get_ip()
    {
        return $this->ip;
    }

    /**
     * @return null
     */
    public function get_user_agent()
    {
        return $this->user_agent;
    }

    /**
     * @return int|string
     */
    public function get_timestamp()
    {
        return $this->timestamp;
    }

    public function save()
    {
        $this->device_id = 'TWOFAS_LIGHT_TRUSTED_DEVICE_' . md5(uniqid());
        $this->device_key = md5(uniqid());
        $this->user->save_user_trusted_device($this);
        $this->cookie->set_trusted_device_cookie($this->device_id, $this->device_key, self::TWOFASLIGHT_COOKIE_TRUSTED_DEVICE_LIFESPAN);
        $this->is_device_trusted = true;
    }

    /**
     * @return $this
     */
    public function try_fetching_trusted_device()
    {
        $trusted_devices = $this->user->get_user_trusted_devices();
        
        if (!$trusted_devices || !is_array($trusted_devices)) {
            return $this;
        }

        foreach ($trusted_devices as $device_id => $data) {
            $cookie_device_key = $this->request->get_from_cookie($device_id);
            if ($cookie_device_key === $data['device_key']) {
                $this->device_id = $device_id;
                $this->device_key = $data['device_key'];
                $this->ip = $data['ip'];
                $this->user_agent = $data['user_agent'];
                $this->timestamp = $data['timestamp'];
                $this->is_device_trusted = true;
                return $this;
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function is_device_trusted()
    {
        return $this->is_device_trusted;
    }
}
