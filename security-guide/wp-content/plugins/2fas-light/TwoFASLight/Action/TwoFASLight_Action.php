<?php

namespace TwoFASLight\Action;

use TwoFASLight\TwoFASLight_App;

abstract class TwoFASLight_Action
{
    /**
     * @param TwoFASLight_App $app
     *
     * @return mixed
     */
    abstract public function handle(TwoFASLight_App $app);
    
}