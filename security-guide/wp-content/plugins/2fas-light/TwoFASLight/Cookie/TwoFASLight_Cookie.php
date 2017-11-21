<?php

namespace TwoFASLight\Cookie;

class TwoFASLight_Cookie
{
    /**
     * @param string $name
     * @param string $value
     * @param int    $lifespan
     *
     * @return bool
     */
    public function set_trusted_device_cookie($name, $value, $lifespan)
    {
        return setcookie($name, $value, $lifespan, '/');
    }
}
