<?php
/*
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * Plugin Name: 2FAS Light - Google Authenticator
 * Plugin URI:  https://wordpress.org/plugins/2fas-light
 * Description: Free, simple, token-based authentication (Google Authenticator) for your WordPress. No registration needed.
 * Version:     1.0.2
 * Author:      Two Factor Authentication Service Inc.
 * Author URI:  https://2fas.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: twofas
 */

defined('ABSPATH') or die();

//  Determine whether full plugin version is installed
function is_full_twofas_plugin_active()
{
    if (!function_exists( 'get_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $active_plugins = get_option('active_plugins');
    $result = false;

    foreach ($active_plugins as $data) {
        $result |= (preg_match('/\/twofas\.php/', $data) === 1);
    }

    return $result;
}

if (is_full_twofas_plugin_active()) {
    define('TWOFAS_LIGHT_FULL_TWOFAS_PLUGIN_ACTIVE_FLAG', true);
    add_action( 'admin_notices', 'full_twofas_plugin_active_notice');
}

function full_twofas_plugin_active_notice()
{
    echo '<div class="notice is-dismissible notice-error error">'
        . '<p>2FAS plugin has been found as active, therefore light version of the plugin is disabled.</p>'
        . '<button class="notice-dismiss" type="button"></button>'
        . '</div>';
}

//  Add actions and filters
add_action('login_enqueue_scripts', 'twofas_light_enqueue');
add_action('admin_enqueue_scripts', 'twofas_light_enqueue');
add_action('init', 'twofas_light_init');

//  Turn off critical functionalities when full plugin is installed
if (!defined('TWOFAS_LIGHT_FULL_TWOFAS_PLUGIN_ACTIVE_FLAG')) {
    add_action('login_form', 'twofas_light_login');
    add_action('wp_ajax_twofas_light_ajax', 'twofas_light_ajax');
    add_filter('authenticate', 'twofas_light_authenticate', 100, 1);
    add_filter('login_errors', 'twofas_light_login_errors');
}

// Override login errors
function twofas_light_login_errors($error) {
    global $errors;

    $error_codes = $errors->get_error_codes();

    if (in_array('invalid_username', $error_codes) || in_array('incorrect_password', $error_codes)) {
        $error = '<strong>ERROR:</strong> Invalid credentials';
    }

    return $error;
}

//  Define constants
define('TWOFAS_LIGHT_PLUGIN_PATH', plugins_url() . DIRECTORY_SEPARATOR . dirname(plugin_basename(__FILE__)));
define('TWOFAS_LIGH_WP_ADMIN_PATH', get_admin_url());
define('TWOFAS_LIGHT_PLUGIN_VERSION', '1.0.2');

//  Store plugin version in database
update_option('twofas_light_plugin_version', TWOFAS_LIGHT_PLUGIN_VERSION);

//  Import application contexts
require_once(__DIR__ . '/vendor/autoload.php');

use TwoFASLight\Action\TwoFASLight_Router;
use TwoFASLight\TwoFASLight_Ajax_App;
use TwoFASLight\TwoFASLight_Authenticate_App;
use TwoFASLight\TwoFASLight_Init_App;
use TwoFASLight\TwoFASLight_Login_App;

//  Different application contexts
//  Doing it that way, in order to separate WP functions from plugin logic
function twofas_light_enqueue()
{
    wp_enqueue_style('twofas-light-icons', TWOFAS_LIGHT_PLUGIN_PATH . '/includes/css/twofas_light_icons.css', array(), TWOFAS_LIGHT_PLUGIN_VERSION);
    wp_enqueue_style('twofas-light', TWOFAS_LIGHT_PLUGIN_PATH . '/includes/css/twofas_light.css', array(), TWOFAS_LIGHT_PLUGIN_VERSION);
    wp_enqueue_style('roboto', 'https://fonts.googleapis.com/css?family=Roboto');
    wp_enqueue_script('jquery');
    wp_enqueue_script('twofas-light-js', TWOFAS_LIGHT_PLUGIN_PATH . '/includes/js/twofas_light.js', array('jquery'), TWOFAS_LIGHT_PLUGIN_VERSION, true);

    wp_localize_script('twofas-light-js', 'twofas_light', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'twofas_light_menu_page' => TwoFASLight_Router::TWOFASLIGHT_MENU
    ));
}

function twofas_light_login()
{
    $app = new TwoFASLight_Login_App();
    $app->run();
    login_footer();
    exit();
}

function twofas_light_init()
{
    $app = new TwoFASLight_Init_App();
    $app->run();
}

function twofas_light_ajax()
{
    $app = new TwoFASLight_Ajax_App();
    $app->run();
}

function twofas_light_authenticate($user)
{
    $app = new TwoFASLight_Authenticate_App();

    //  Init TwoFASLight_User object, based on passed $user
    if (is_a($user, '\WP_User')) {
        $app->set_user_id($user->ID);
    }

    $result = $app->run();

    if ($result) {
        return $result;
    }

    return $user;
}
