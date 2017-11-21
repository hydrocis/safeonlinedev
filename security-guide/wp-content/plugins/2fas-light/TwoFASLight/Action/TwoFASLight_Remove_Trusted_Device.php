<?php

namespace TwoFASLight\Action;

use TwoFASLight\Result\TwoFASLight_Result_JSON;
use TwoFASLight\TwoFASLight_App;

class TwoFASLight_Remove_Trusted_Device extends TwoFASLight_Action
{
    /**
     * @param TwoFASLight_App $app
     *
     * @return null|TwoFASLight_Result_JSON
     */
    public function handle(TwoFASLight_App $app)
    {
        $device_id = $app->get_request()->get_from_post('device_id');
        
        if (!$device_id
            || !$app->get_user()->remove_trusted_device($device_id)
        ) {
            return null;
        }

        $trusted_devices = $app->get_view_renderer()->render('trusted_devices.html.twig', array(
            'trusted_devices' => $app->get_user()->get_user_trusted_devices()
        ));

        return new TwoFASLight_Result_JSON(array(
            'twofas_light_result' => 'success',
            'device_id' => $device_id,
            'twofas_light_trusted_devices' => $trusted_devices
        ));
    }
}
