<?php

namespace TwoFASLight;

use TwoFASLight\Request\TwoFASLight_Ajax_Request;
use TwoFASLight\Result\TwoFASLight_JSON_Consumer;

class TwoFASLight_Ajax_App extends TwoFASLight_App implements TwoFASLight_JSON_Consumer
{
    public function run()
    {
        $this->request = new TwoFASLight_Ajax_Request();
        $this->request->fill_with_context($this->request_context);

        // Verify nonce
        check_ajax_referer('twofas_light_ajax', 'security');
 
        //  Pass Request to Router
        $action = $this->router->get_action($this->request);

        //  Execute Action
        $result = $action->handle($this);
        $result->feed_consumer($this);
    }

    /**
     * @param $json
     */
    public function consume_json($json)
    {
        wp_send_json($json);
    }
}
