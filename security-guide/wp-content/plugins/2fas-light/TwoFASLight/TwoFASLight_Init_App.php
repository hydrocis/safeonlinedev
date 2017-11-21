<?php

namespace TwoFASLight;

use TwoFASLight\Menu\TwoFASLight_Menu;
use TwoFASLight\Request\TwoFASLight_Regular_Request;
use TwoFASLight\Result\TwoFASLight_HTML_Consumer;

class TwoFASLight_Init_App extends TwoFASLight_App implements TwoFASLight_HTML_Consumer
{
    public function run()
    {   
        $this->request = new TwoFASLight_Regular_Request();
        $this->request->fill_with_context($this->request_context);
        
        //  Pass Request to Router
        $action = $this->router->get_action($this->request);

        //  Execute Action
        $result = $action->handle($this);
        $result->feed_consumer($this);
    }

    /**
     * @param $html
     */
    public function consume_html($html)
    {
        $menu = new TwoFASLight_Menu();
        $menu->run($html);
    }
}
