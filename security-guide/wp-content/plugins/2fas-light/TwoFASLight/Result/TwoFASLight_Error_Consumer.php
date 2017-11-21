<?php

namespace TwoFASLight\Result;

interface TwoFASLight_Error_Consumer
{
    /**
     * @param $error
     *
     * @return mixed
     */
    public function consume_error($error);
}
