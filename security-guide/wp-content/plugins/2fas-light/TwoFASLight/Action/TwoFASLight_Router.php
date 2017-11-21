<?php

namespace TwoFASLight\Action;

use TwoFASLight\Request\TwoFASLight_Request;

class TwoFASLight_Router
{
    const TWOFASLIGHT_MENU = 'twofas_light_menu';

    const TWOFAS_ACTION_DEFAULT = 'twofas_light_menu_display';
    const TWOFAS_ACTION_RELOAD_QR_CODE = 'twofas_light_reload_qr_code';
    const TWOFAS_ACTION_CONFIGURE_TOTP = 'twofas_light_configure_totp';
    const TWOFAS_ACTION_TOTP_ENABLE_DISABLE = 'twofas_light_totp_enable_disable';
    const TWOFAS_ACTION_REMOVE_TRUSTED_DEVICE = 'twofas_light_remove_trusted_device';

    /**
     * @var array
     */
    private $map = array(
        self::TWOFASLIGHT_MENU => array(
            self::TWOFAS_ACTION_DEFAULT => 'TwoFASLight\Action\TwoFASLight_Menu_Action',
            self::TWOFAS_ACTION_RELOAD_QR_CODE => 'TwoFASLight\Action\TwoFASLight_Reload_QR_Code',
            self::TWOFAS_ACTION_CONFIGURE_TOTP => 'TwoFASLight\Action\TwoFASLight_Configure_TOTP',
            self::TWOFAS_ACTION_TOTP_ENABLE_DISABLE => 'TwoFASLight\Action\TwoFASLight_TOTP_Enable_Disable',
            self::TWOFAS_ACTION_REMOVE_TRUSTED_DEVICE => 'TwoFASLight\Action\TwoFASLight_Remove_Trusted_Device'
        )
    );
    
    /**
     * @param TwoFASLight_Request $request
     * 
     * @return TwoFASLight_Action
     */
    public function get_action(TwoFASLight_Request $request)
    {
        $page = $request->get_page();
        $action = $request->get_action();

        if (!$this->validate_page_action_pair($page, $action)) {
            return new TwoFASLight_Menu_Action();
        }

        $actions_on_page = isset($this->map[$page]) ? $this->map[$page] : self::TWOFASLIGHT_MENU;

        if (is_string($action)) {
            $action_name = isset($actions_on_page[$action]) ? $action : self::TWOFAS_ACTION_DEFAULT;
        } else {
            $action_name = self::TWOFAS_ACTION_DEFAULT;
        }

        return new $actions_on_page[$action_name];
    }

    /**
     * @param $page
     * @param $action
     *
     * @return bool
     */
    public function validate_page_action_pair($page, $action) 
    {
        return is_string($page) 
            && is_string($action)
            && preg_match('/^twofas_light_[a-z_]+$/', $page) === 1
            && isset($this->map[$page]);
    }
}
