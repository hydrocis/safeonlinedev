<?php

namespace TwoFASLight\Result;

use TwoFASLight\User\TwoFASLight_User;

class TwoFASLight_Result_User implements TwoFASLight_Result
{
    /**
     * @var mixed
     */
    private $user_id;

    /**
     * TwoFASLight_Result_User constructor.
     *
     * @param TwoFASLight_User $user
     */
    public function __construct(TwoFASLight_User $user)
    {
        $this->user_id = $user->get_id();
    }

    /**
     * @param TwoFASLight_User_Consumer $consumer
     *
     * @return mixed
     */
    public function feed_consumer(TwoFASLight_User_Consumer $consumer)
    {
        return $consumer->consume_user($this->user_id);
    }
}
