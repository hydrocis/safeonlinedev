<?php

namespace TwoFASLight\Action;

use TwoFASLight\Result\TwoFASLight_Result_JSON;
use TwoFASLight\TwoFASLight_App;

class TwoFASLight_Reload_QR_Code extends TwoFASLight_Action
{
    /**
     * @param TwoFASLight_App $app
     *
     * @return TwoFASLight_Result_JSON
     */
    public function handle(TwoFASLight_App $app)
    {
        $totp        = $app->get_totp();
        $totp_secret = $totp->generate_totp_secret();
        $qr_code     = $totp->generate_qr_code($totp_secret);
        
        return new TwoFASLight_Result_JSON(array(
            'twofas_light_totp_secret' => $totp_secret,
            'twofas_light_qr_code'     => $qr_code
        ));
    }
}
