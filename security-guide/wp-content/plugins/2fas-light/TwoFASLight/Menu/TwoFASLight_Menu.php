<?php

namespace TwoFASLight\Menu;

class TwoFASLight_Menu
{
    /**
     * @var string
     */
    private $menu_id = 'twofas-light-menu';

    /**
     * @var string
     */
    private $menu_name = '2FAS Light';

    /**
     * @var string
     */
    private $menu_title = '2FAS Light';

    /**
     * @var string
     */
    private $capability = 'level_0';

    /**
     * @var string
     */
    private $view;

    /**
     * @param $view
     */
    public function run($view)
    {
        $this->view = $view;
        add_action('admin_menu', array($this, 'init_menu'));
    }

    public function init_menu()
    {
        add_menu_page(
            $this->menu_title,
            $this->menu_name,
            $this->capability,
            $this->menu_id,
            array($this, 'init_submenu'),
            TWOFAS_LIGHT_PLUGIN_PATH . '/includes/img/icon.svg'
        );
    }

    public function init_submenu()
    {
        echo $this->view;
    }
}
