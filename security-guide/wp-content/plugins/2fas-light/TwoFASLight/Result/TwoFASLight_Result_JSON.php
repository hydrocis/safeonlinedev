<?php

namespace TwoFASLight\Result;

class TwoFASLight_Result_JSON implements TwoFASLight_Result
{
    /**
     * @var string
     */
    private $json;

    /**
     * TwoFASLight_Result_JSON constructor.
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->json = json_encode($array);
    }

    /**
     * @param TwoFASLight_JSON_Consumer $consumer
     */
    public function feed_consumer(TwoFASLight_JSON_Consumer $consumer)
    {
        $consumer->consume_json($this->json);
    }

    /**
     * @return string
     */
    public function get_json()
    {
        return $this->json;
    }
}
