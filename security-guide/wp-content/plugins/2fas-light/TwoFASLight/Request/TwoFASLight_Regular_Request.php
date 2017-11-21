<?php

namespace TwoFASLight\Request;

class TwoFASLight_Regular_Request extends TwoFASLight_Request
{
    /**
     * @var bool
     */
    protected $is_ajax_request = false;

    /**
     * @return mixed
     */
    public function get_page()
    {
        return $this->get_from_get('page');
    }

    /**
     * @return mixed
     */
    public function get_action()
    {
        return $this->get_from_get('twofas_light_action');
    }
}
