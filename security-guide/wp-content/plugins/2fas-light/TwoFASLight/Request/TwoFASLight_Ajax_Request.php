<?php

namespace TwoFASLight\Request;

class TwoFASLight_Ajax_Request extends TwoFASLight_Request
{
    /**
     * @var bool
     */
    protected $is_ajax_request = true;

    /**
     * @return mixed
     */
    public function get_page()
    {
        return $this->get_from_post('page');
    }

    /**
     * @return mixed
     */
    public function get_action()
    {
        return $this->get_from_post('twofas_light_action');
    }
}
