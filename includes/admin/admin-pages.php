<?php
/**
 * Admin Pages
 *
 * @package     CHC
 * @subpackage  Admin/Pages
 * @copyright   Copyright (c) 2013, Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function chc_add_options_link() {
	global $chc_settings_page, $chc_system_info;

	require_once 'system-info.php';

	$chc_settings_page = add_menu_page( __( 'Custom Help Center Settins', 'chc' ), __( 'Help Center', 'chc' ), 'install_plugins', 'chc-settings', 'chc_options_page' );
	$chc_system_info = add_submenu_page( 'chc-settings', __( 'Customer Help Center System Info', 'chc' ), __( 'System Info', 'chc' ), 'install_plugins', 'chc-system-info', 'chc_system_info' );
}

add_action( 'admin_menu', 'chc_add_options_link', 10 );
