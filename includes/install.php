<?php
/**
 * Install Function
 *
 * @package     halt
 * @subpackage  Functions/Install
 * @author   	Ram Ratan Maurya
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Install
 *
 * Runs on plugin install by setting up the post types, custom taxonomies,
 * flushing rewrite rules to initiate the new 'article' and other slugs and also
 * creates the plugin and populates the settings fields for those plugin
 * pages. After successfull install, the user is redirected to the Halt Welcome
 * screen.
 *
 * @since 1.0
 * @global $wpdb
 * @global $halt_options
 * @global $wp_version
 * @return void
 */
function halt_install() {
	global $wpdb, $halt_options, $wp_version;

	// Setup the custom post types
	halt_setup_halt_post_types();

	// Clear the permalinks
	flush_rewrite_rules();

	// Check if tickets page exists
	if( ! isset( $halt_options['tickets_page'] ) ) {
		$ticket = wp_insert_post( 
			array(
				'post_title'     => __( 'Tickets', 'halt' ),
				'post_content'   => '[halt_tickets]',
				'post_status'    => 'publish',
				'post_author'    => 1,
				'post_type'      => 'page',
				'comment_status' => 'closed'
			)
		);

		$profile = wp_insert_post( 
			array(
				'post_title'     => __( 'Profile', 'halt' ),
				'post_content'   => '[halt_profile]',
				'post_status'    => 'publish',
				'post_author'    => 1,
				'post_type'      => 'page',
				'comment_status' => 'closed'
			)
		);
	}

	// Bail if activating from network, or bulk
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
		return;

	// Add the transient to redirect
	set_transient( '_halt_activation_redirect', true, 30 );
}
register_activation_hook( HALT_PLUGIN_FILE, 'halt_install' );