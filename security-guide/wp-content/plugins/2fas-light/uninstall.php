<?php

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require_once 'twofas_light_uninstaller.php';

$uninstaller = new TwoFASLight_Uninstaller();
$uninstaller->uninstall();
