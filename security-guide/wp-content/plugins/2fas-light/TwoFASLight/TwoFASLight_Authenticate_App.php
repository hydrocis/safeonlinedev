<?php

namespace TwoFASLight;

use TwoFASLight\Action\TwoFASLight_Authenticate;
use TwoFASLight\Request\TwoFASLight_Regular_Request;
use TwoFASLight\Result\TwoFASLight_HTML_Consumer;
use TwoFASLight\Result\TwoFASLight_User_Consumer;

class TwoFASLight_Authenticate_App extends TwoFASLight_App implements TwoFASLight_HTML_Consumer, TwoFASLight_User_Consumer
{
    public function run()
    {
        $this->request = new TwoFASLight_Regular_Request();
        $this->request->fill_with_context($this->request_context);
        
        $action = new TwoFASLight_Authenticate();
        $result = $action->handle($this);
        
        if (!$result) {
            return null;
        }
        
        return $result->feed_consumer($this);
    }

    /**
     * @param $user_id
     */
    public function set_user_id($user_id)
    {
        $this->get_user()->set_id($user_id);
    }

    /**
     * @param $user_id
     *
     * @return \WP_User
     */
    public function consume_user($user_id)
    {
        return new \WP_User($user_id);
    }

    /**
     * @param $html
     */
    public function consume_html($html)
    {
        login_header();
        echo $html;
        login_footer();
        exit();
    }
}
