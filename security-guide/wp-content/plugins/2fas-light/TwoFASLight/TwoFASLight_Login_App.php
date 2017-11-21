<?php

namespace TwoFASLight;

use TwoFASLight\Action\TwoFASLight_Login;
use TwoFASLight\Request\TwoFASLight_Regular_Request;
use TwoFASLight\Result\TwoFASLight_HTML_Consumer;

class TwoFASLight_Login_App extends TwoFASLight_App implements TwoFASLight_HTML_Consumer
{
    public function run()
    {
        $this->request = new TwoFASLight_Regular_Request();
        $this->request->fill_with_context($this->request_context);
        
        $action = new TwoFASLight_Login();
        $result = $action->handle($this);
        $result->feed_consumer($this);
    }

    /**
     * @param $html
     */
    public function consume_html($html)
    {
        echo $html;
    }
}
