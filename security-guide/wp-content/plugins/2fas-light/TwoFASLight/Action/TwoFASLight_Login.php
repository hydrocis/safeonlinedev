<?php

namespace TwoFASLight\Action;

use TwoFASLight\Result\TwoFASLight_Result_HTML;
use TwoFASLight\TwoFASLight_App;

class TwoFASLight_Login extends TwoFASLight_Action
{
    /**
     * @param TwoFASLight_App $app
     *
     * @return TwoFASLight_Result_HTML
     */
    public function handle(TwoFASLight_App $app)
    {
        $token = md5(uniqid('', true));
        
        $html = $app->get_view_renderer()->render('login_first_step.html.twig', array(
            'twofas_light_step_token' => $token,
            'interim_login' => $app->get_request()->get_from_request('interim-login')
        ));
        
        return new TwoFASLight_Result_HTML($html);
    }
}
