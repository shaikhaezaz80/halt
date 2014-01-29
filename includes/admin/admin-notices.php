<?php
/**
 * Halt Admin Pages
 *
 * @package     Halt
 * @subpackage  Admin/Notices
 * @author 		Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Admin Messages
 *
 * @global $halt_options Array of all the Halt Options
 * @return void
 */
function halt_admin_messages() {
	global $halt_options;

	if ( isset( $_GET['halt-message'] ) && 'settings-imported' == $_GET['halt-message'] && current_user_can('manage_halt') ) {
		add_settings_error( 'halt-notices', 'halt-settings-imported', __( 'The settings have been imported.', 'halt' ), 'updated' );
	}

	settings_errors( 'halt-notices' );
}
add_action( 'admin_notices', 'halt_admin_messages' );
