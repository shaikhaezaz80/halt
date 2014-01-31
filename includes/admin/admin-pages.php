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
 * @global $halt_tools_page
 * @return void
 */
function halt_add_options_link() {
	global $halt_settings_page, $halt_system_info, $halt_tools_page;

	require_once 'system-info.php';

	add_admin_menu_separator(30);
	add_admin_menu_separator(35);

	$halt_settings_page = add_menu_page( __( 'Halt Settings', 'halt' ), __( 'Halt', 'halt' ), 'manage_halt', 'halt-settings', 'halt_options_page', null, 31 );
	$halt_tools_page    = add_submenu_page( 'halt-settings', __( 'Halt Tools', 'halt' ), __( 'Tools', 'halt' ), 'install_plugins', 'halt-tools', 'halt_tools_page' );
	$halt_system_info   = add_submenu_page( 'halt-settings', __( 'Halt System Info', 'halt' ), __( 'System Info', 'halt' ), 'install_plugins', 'halt-system-info', 'halt_system_info' );
}

add_action( 'admin_menu', 'halt_add_options_link', 9 );

/**
 * Create Admin Menu Separator
 *
 * @param int $position Position of admin menu item
 * @return void
 */
function add_admin_menu_separator( $position ) {

	global $menu;
	$index = 0;

	foreach ( $menu as $offset => $section ) {
		if ( substr( $section[2], 0, 9 ) == 'separator' ) {
		    $index++;
		}
		if ( $offset >= $position ) {
			$menu[$position] = array( '', 'read', "separator{$index}", '', 'wp-menu-separator' );
			break;
	    }
	}

	ksort( $menu );
}
