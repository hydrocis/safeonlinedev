<?php

namespace TwoFASLight\Result;

interface TwoFASLight_HTML_Consumer 
{
    /**
     * @param $html
     */
    public function consume_html($html);
}
