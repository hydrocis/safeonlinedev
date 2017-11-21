<?php

namespace TwoFASLight\Result;

class TwoFASLight_Result_Error implements TwoFASLight_Result
{
    /**
     * @var
     */
    private $error;

    /**
     * TwoFASLight_Result_Error constructor.
     *
     * @param $error
     */
    public function __construct($error)
    {
        $this->error = $error;
    }

    /**
     * @param TwoFASLight_Error_Consumer $consumer
     */
    public function feed_consumer(TwoFASLight_Error_Consumer $consumer)
    {
        $consumer->consume_error($this->error);
    }
}
