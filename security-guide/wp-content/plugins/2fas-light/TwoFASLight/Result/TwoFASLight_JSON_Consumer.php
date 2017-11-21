<?php

namespace TwoFASLight\Result;

interface TwoFASLight_JSON_Consumer 
{
    /**
     * @param $json
     */
    public function consume_json($json);
}
