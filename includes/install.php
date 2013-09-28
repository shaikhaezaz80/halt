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
	halt_install_default_taxonomies();

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

		// Store Page IDs
		$options = array(
			'tickets_page' => $ticket,
			'profile_page' => $profile
		);

		update_option( 'halt_settings_general', $options );
		update_option( 'halt_version', HALT_VERSION );

		// Add a temporary option to note that Halt pages have been created
		set_transient( '_halt_activation_pages', $options, 30 );
	}

	// Bail if activating from network, or bulk
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
		return;

	// Add the transient to redirect
	set_transient( '_halt_activation_redirect', true, 30 );
}
register_activation_hook( HALT_PLUGIN_FILE, 'halt_install' );

/**
 * Install default taxonomies for Tickets
 * 
 * @return void
 */
function halt_install_default_taxonomies() {
	/** Ticket Priorities */
	$terms = array( 'low', 'medium', 'high', 'urgent' );
	$loop  = 1;

	if ( $terms ) {
		foreach ( $terms as $term ) {
			if ( ! get_term_by( 'slug', sanitize_title($term), 'ticket_priority' ) ) {
				wp_insert_term( $term, 'ticket_priority', array( 'description' => $loop ) );
				$loop++;
			}
		}
	}

	/** Ticket Statuses */
	$terms = array( 'new', 'open', 'pending', 'closed' );
	$loop  = 1;
	if ( $terms ) {
		foreach ( $terms as $term ) {
			if ( ! get_term_by( 'slug', sanitize_title($term), 'ticket_status' ) ) {
				wp_insert_term( $term, 'ticket_status', array( 'description' => $loop ) );
				$loop++;
			}
		}
	}

	/** Ticket Type */
	$terms = array( 'question', 'issue', 'suggestion', 'task' );
	$loop  = 1;
	if ( $terms ) {
		foreach ( $terms as $term ) {
			if ( ! get_term_by( 'slug', sanitize_title($term), 'ticket_type' ) ) {
				wp_insert_term( $term, 'ticket_type', array( 'description' => $loop ) );
				$loop++;
			}
		}
	}	
}

/**
 * Post-installation
 *
 * Runs just after plugin installation and exposes the
 * 
 * @uses halt_after_install Hook
 * @since 1.0
 * @return void
 */
function halt_after_install() {

	if( ! is_admin() )
		return;

	$activation_pages = get_transient( '_halt_activation_pages' );

	// Exit if not in admin or the transient doesn't exist
	if ( false === $activation_pages )
		return;

	// Delete the transient
	delete_transient( '_halt_activation_pages' );

	do_action( 'halt_after_install', $activation_pages );
}
add_action( 'admin_init', 'halt_after_install' );