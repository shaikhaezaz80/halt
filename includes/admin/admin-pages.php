<?php
/**
 * Halt Admin Pages
 *
 * @package     Halt
 * @subpackage  Admin/Pages
 * @author 		Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Creates the admin submenu pages under the Downloads menu and assigns their
 * links to global variables.
 *
 * @global $halt_settings_page
 * @global $halt_system_info
 * @return void
 */
function halt_add_options_link() {
	global $halt_settings_page, $halt_system_info;

	require_once 'system-info.php';

	$halt_settings_page = add_menu_page( __( 'Halt Settings', 'halt' ), __( 'Halt', 'halt' ), 'manage_halt', 'halt-settings', 'halt_options_page', false, 3 );
	$halt_system_info   = add_submenu_page( 'halt-settings', __( 'Halt System Info', 'halt' ), __( 'System Info', 'halt' ), 'manage_halt', 'halt-system-info', 'halt_system_info' );
}

add_action( 'admin_menu', 'halt_add_options_link', 9 );
