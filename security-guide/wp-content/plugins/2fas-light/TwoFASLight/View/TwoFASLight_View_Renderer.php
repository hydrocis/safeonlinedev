<?php

namespace TwoFASLight\View;

use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFunction;
use TwoFASLight\Browser\TwoFASLight_Browser;

class TwoFASLight_View_Renderer
{
    /**
     * @var string
     */
    private $templates_path;

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function init()
    {
        $this->templates_path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'view';
        $twig_loader = new Twig_Loader_Filesystem($this->templates_path);
        $this->twig = new Twig_Environment($twig_loader);
        $this->twig->addFunction(new Twig_SimpleFunction('timestamp_to_wp_datetime', array($this, 'timestamp_to_wp_datetime')));
        $this->twig->addFunction(new Twig_SimpleFunction('describe_device', array($this, 'describe_device')));
    }

    /**
     * @param $template
     * @param $arguments
     *
     * @return string
     */
    public function render($template, $arguments)
    {
        $arguments['twofas_plugin_path'] = TWOFAS_LIGHT_PLUGIN_PATH;
        $arguments['twofas_admin_path'] = TWOFAS_LIGH_WP_ADMIN_PATH;
        $arguments['twofas_full_plugin_is_active'] = defined('TWOFAS_LIGHT_FULL_TWOFAS_PLUGIN_ACTIVE_FLAG');
        $arguments['login_url'] = wp_login_url();
        $arguments['nonce_field'] = wp_nonce_field('twofas_light_ajax', $name = "_wpnonce", $referer = false , $echo = false );
        return $this->twig->render($template, $arguments);
    }

    /**
     * @param $user_agent
     *
     * @return string
     */
    public function describe_device($user_agent)
    {
        $twofas_browser = new TwoFASLight_Browser($user_agent);
        return $twofas_browser->describe();
    }

    /**
     * @param $timestamp
     *
     * @return string
     */
    public function timestamp_to_wp_datetime($timestamp)
    {
        $stamp     = new \DateTime("@" . $timestamp);
        $time_zone = get_option('timezone_string');

        if (!$time_zone) {
            $time_zone = 'UTC';
        }

        $stamp->setTimezone(new \DateTimeZone($time_zone));
        $time = $stamp->format(get_option('time_format'));
        $date = $stamp->format(get_option('date_format'));

        return $date . ' ' . $time;
    }
}
