<?php

namespace TwoFASLight\Action;

use TwoFASLight\Result\TwoFASLight_Result_JSON;
use TwoFASLight\TwoFASLight_App;

class TwoFASLight_Configure_TOTP extends TwoFASLight_Action
{
    /**
     * @param TwoFASLight_App $app
     *
     * @return TwoFASLight_Result_JSON
     */
    public function handle(TwoFASLight_App $app)
    {
        $totp    = $app->get_totp();
        $user    = $app->get_user();
        $request = $app->get_request();
        
        $new_totp_secret = $request->get_from_post('twofas_light_totp_secret');
        $new_totp_token  = $request->get_from_post('twofas_light_totp_token');
        
        $result = 'error';

        if ($totp->check_code($new_totp_secret, $new_totp_token)) {
            $old_totp_secret = $user->get_totp_secret();
            $user->set_totp_secret($new_totp_secret);
            $user->enable_totp();
            $result = 'success';

            if ($new_totp_secret !== $old_totp_secret) {
                $app->get_user()->remove_trusted_devices();
            }
        }

        $trusted_devices_template = $app->get_view_renderer()->render('trusted_devices.html.twig', array(
            'trusted_devices' => $app->get_user()->get_user_trusted_devices()
        ));

        return new TwoFASLight_Result_JSON(array(
            'twofas_light_totp_secret'     => $new_totp_secret,
            'twofas_light_totp_token'      => $new_totp_token,
            'twofas_light_result'          => $result,
            'twofas_light_trusted_devices' => $trusted_devices_template
        ));
    }
}
