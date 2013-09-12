<?php
/**
 * Scripts
 *
 * @package     CHC
 * @subpackage  Functions
 * @copyright   Copyright (c) 2013, Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Load Scripts
 *
 * Enqueues the required scripts.
 *
 * @since 1.0
 * @global $chc_options
 * @global $post
 * @return void
 */
function chc_load_scripts() {
	global $chc_options, $post;

	$js_dir = CHC_PLUGIN_URL . 'assets/js/';

	wp_enqueue_script( 'jquery' );

	define('SCRIPT_DEBUG', true);

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_register_script( 'chc-app', $js_dir . 'frontend/chc-app' . $suffix . '.js', array( 'backbone' ), CHC_VERSION, true );
	wp_register_script( 'chc-views', $js_dir . 'frontend/chc-views' . $suffix . '.js', array( 'backbone' ), CHC_VERSION, true );
	wp_register_script( 'chc-models', $js_dir . 'frontend/chc-models' . $suffix . '.js', array( 'backbone' ), CHC_VERSION, true );
	wp_register_script( 'chc-collections', $js_dir . 'frontend/chc-collections' . $suffix . '.js', array( 'backbone' ), CHC_VERSION, true );
	wp_register_script( 'chc-routers', $js_dir . 'frontend/chc-routers' . $suffix . '.js', array( 'backbone' ), CHC_VERSION, true );
	
	wp_enqueue_script( 'chc-main', $js_dir . 'frontend/chc-main' . $suffix . '.js', array(
		'jquery',
		'backbone',
		'chc-app',
		'chc-collections',
		'chc-models',
		'chc-views',
		'chc-routers'
	), CHC_VERSION, true );

	global $paged;

	// Create the path; should be in the form of "blah/blah/"
	$path = $_SERVER['REQUEST_URI'];

	// Trim "/" from in front of the path
	$path = ltrim( $path, '/' );

	// Add "/" to the end
	if ( get_option( 'permalink_structure' ) ) {
		$path = trailingslashit( $path );
	} elseif ( empty( $path ) ) {
		$path = '/';
	}

	wp_localize_script( 'chc-app', 'chcData', array(
		'ajaxurl'          => admin_url('admin-ajax.php'),
		
		// Basic introspection methods
		'get_recent_posts' => esc_url( home_url('/api/get_recent_posts') ),
		'get_posts' => esc_url( home_url('/api/get_posts') ),
		'get_post' => esc_url( home_url('/api/get_post') ),
		'get_page' => esc_url( home_url('/api/get_page') ),
		

		// Data Manipulation for posts
		'create_post' => esc_url( home_url('/api/create_post') ),
		'update_post' => esc_url( home_url('/api/update_post') ),
		'delete_post' => esc_url( home_url('/api/delete_post') ),

		'isSingle'         => ( is_single() ) ? 1 : 0,
		'isTax'            => ( is_tax() ) ? 1 : 0,
		'isFrontPage'      => ( is_front_page() ) ? 1 : 0,
		'isArchive'        => ( is_archive() ) ? 1 : 0,
		'page'             => $paged,
		'pathname'         => $path,
		'permalink'        => ( get_option( 'permalink_structure' ) ) ? 1 : 0,
	));
}
// add_action( 'wp_enqueue_scripts', 'chc_load_scripts' );
	
/**
 * Adds CHC Version to the <head> tag
 *
 * @since 1.4.2
 * @return void
*/
function chc_version_in_header(){
	// Newline on both sides to avoid being in a blob
	echo '<meta name="generator" content="Customer Help Center v' . CHC_VERSION . '" />' . "\n";
}
add_action( 'wp_head', 'chc_version_in_header' );
