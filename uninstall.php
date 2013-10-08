<?php
/**
 * Uninstall Halt
 *
 * @package     Halt
 * @subpackage  Uninstall
 * @author 		Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

// Load Halt file
include_once( 'halt.php' );

global $halt_options;

/** Delete the Plugin Pages */
if ( isset( $halt_options['tickets_page'] ) )
	wp_delete_post( $halt_options['tickets_page'], true );
if ( isset( $halt_options['profile_page'] ) )
	wp_delete_post( $halt_options['profile_page'], true );

/** Delete all the Plugin Options */
delete_option( 'halt_settings_general' );
delete_option( 'halt_settings_article' );

/** Delete Capabilities */
HALT()->roles->remove_caps();

/** Delete the Roles */
$halt_roles = array( 'support_staff' );
foreach ( $halt_roles as $role ) {
	remove_role( $role );
}
