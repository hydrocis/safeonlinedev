<?php

namespace TwoFASLight\Action;

use TwoFASLight\Result\TwoFASLight_Result_HTML;
use TwoFASLight\TwoFASLight_App;
use TwoFASLight\User\TwoFASLight_User;

class TwoFASLight_Menu_Action extends TwoFASLight_Action
{
    /**
     * @param TwoFASLight_App $app
     *
     * @return TwoFASLight_Result_HTML
     */
    public function handle(TwoFASLight_App $app)
    {
        $totp = $app->get_totp();
        $user = $app->get_user();
        
        if (!$user->is_totp_configured()) {
            $totp_secret = $totp->generate_totp_secret();
        } else {
            $totp_secret = $user->get_totp_secret();
        }

        $qr_code = $totp->generate_qr_code($totp_secret);

        $html = $app->get_view_renderer()->render('plugin_main_page.html.twig', array(
            'qr_code' => $qr_code,
            'totp_secret' => $totp_secret,
            'twofas_light_menu_page' => TwoFASLight_Router::TWOFASLIGHT_MENU,
            TwoFASLight_User::TWOFAS_LIGHT_TOTP_STATUS => $user->get_totp_status(),
            'trusted_devices' => $user->get_user_trusted_devices()
        ));
        
        return new TwoFASLight_Result_HTML($html);
    }
}
