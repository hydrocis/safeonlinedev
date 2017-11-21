<?php

namespace TwoFASLight\Action;

use TwoFASLight\Result\TwoFASLight_Result_JSON;
use TwoFASLight\TwoFASLight_App;

class TwoFASLight_TOTP_Enable_Disable extends TwoFASLight_Action
{
    /**
     * @param TwoFASLight_App $app
     *
     * @return TwoFASLight_Result_JSON
     */
    public function handle(TwoFASLight_App $app)
    {
        $user = $app->get_user();
        $is_totp_configured = $user->is_totp_configured();
        
        $result = 'error';
        
        if ($is_totp_configured && $user->is_totp_enabled()) {
            $user->disable_totp();
            $result = 'success';
        } elseif ($is_totp_configured && !$user->is_totp_enabled()) {
            $user->enable_totp();
            $result = 'success';
        }

        return new TwoFASLight_Result_JSON(array(
            'twofas_light_result'      => $result,
            'twofas_light_totp_status' => $user->get_totp_status()
        ));
    }
}
