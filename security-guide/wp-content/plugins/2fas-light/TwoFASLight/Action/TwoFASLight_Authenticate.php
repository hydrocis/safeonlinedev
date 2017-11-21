<?php

namespace TwoFASLight\Action;

use TwoFASLight\Result\TwoFASLight_Result_HTML;
use TwoFASLight\Result\TwoFASLight_Result_User;
use TwoFASLight\TwoFASLight_App;

class TwoFASLight_Authenticate extends TwoFASLight_Action
{
    /**
     * @param TwoFASLight_App $app
     *
     * @return null|TwoFASLight_Result_HTML|TwoFASLight_Result_User
     */
    public function handle(TwoFASLight_App $app)
    {
        $request       = $app->get_request();
        $user          = $app->get_user();
        $step_token    = $request->get_from_post('twofas_light_step_token');
        $error_message = null;
        
        //  Load user based on step token
        $user->get_user_by_step_token($step_token);
        
        //  Invalid request
        if (!$request->is_post_request() || !$user->get_id()) {
            return null;
        }
        
        //  User is not using 2FA
        if (!$user->is_totp_configured()
            || !$user->is_totp_enabled()
            || $app->get_trusted_device()->try_fetching_trusted_device()->is_device_trusted()
        ) {
            return new TwoFASLight_Result_User($user);
        }

        //  If valid step and totp token are supplied,
        $totp               = $app->get_totp();
        $totp_token         = $request->get_from_post('twofas_light_totp_token');
        $totp_secret        = $user->get_totp_secret();
        $valid_code         = $totp->check_code($totp_secret, $totp_token);
        $valid_token_format = $this->validate_token_format($totp_token);

        if (is_string($totp_token) && empty($totp_token)) {
            $error_message = 'Token cannot be empty';
        } elseif (is_string($totp_token) && !$valid_token_format) {
            $error_message = 'Token is not in a valid format';
        } elseif ($valid_token_format && $valid_code && !$user->is_blocked()) {
            if ($request->get_from_post('twofas_light_save_device_as_trusted')) {
                $app->get_trusted_device()->save();
            }

            $user->reset_failed_logins_counter();

            return new TwoFASLight_Result_User($user);
        } elseif (!$valid_code && $valid_token_format) {
            $user->increment_failed_logins_counter();
            $error_message = 'Token is invalid';
        } elseif ($valid_code && $valid_token_format && $user->is_blocked()) {
            $error_message = 'Your account is temporarily blocked';
        }

        //  Display login form
        $user->set_step_token($step_token);

        $html = $app->get_view_renderer()->render('login_second_step.html.twig', array(
            'twofas_light_step_token' => $step_token,
            'wp_login_url' => wp_login_url(),
            'twofas_light_error_message' => $error_message,
            'rememberme' => $request->get_from_post('rememberme'),
            'redirect_to' => $request->get_from_post('redirect_to'),
            'testcookie' => $request->get_from_post('testcookie'),
            'reauth' => $request->get_from_post('reauth'),
            'twofas_light_save_device_as_trusted' => $request->get_from_post('twofas_light_save_device_as_trusted'),
            'interim_login' => $request->get_from_post('interim-login')
        ));
        
        return new TwoFASLight_Result_HTML($html);
    }

    /**
     * @param $token
     *
     * @return bool
     */
    private function validate_token_format($token)
    {
        return is_string($token) && preg_match('/^\d{6}$/', $token) === 1;
    }
}
