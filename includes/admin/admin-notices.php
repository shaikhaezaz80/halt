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
	settings_errors( 'halt-notices' );
}
add_action( 'admin_notices', 'halt_admin_messages' );
