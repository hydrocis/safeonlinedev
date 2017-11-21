<?php

namespace TwoFASLight\Result;

interface TwoFASLight_User_Consumer
{
    /**
     * @param $user_id
     */
    public function consume_user($user_id);
}
