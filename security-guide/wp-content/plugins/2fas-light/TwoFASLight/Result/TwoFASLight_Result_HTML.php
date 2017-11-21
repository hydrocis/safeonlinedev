<?php

namespace TwoFASLight\Result;

class TwoFASLight_Result_HTML implements TwoFASLight_Result
{
    /**
     * @var
     */
    private $html;

    /**
     * TwoFASLight_Result_HTML constructor.
     *
     * @param $html
     */
    public function __construct($html)
    {
        $this->html = $html;
    }

    /**
     * @param TwoFASLight_HTML_Consumer $consumer
     */
    public function feed_consumer(TwoFASLight_HTML_Consumer $consumer)
    {
        $consumer->consume_html($this->html);
        return;
    }
}
