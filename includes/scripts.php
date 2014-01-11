<?php
/**
 * Scripts.
 *
 * @package     Halt
 * @subpackage  Functions
 * @author 		Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Load Scripts.
 *
 * Enqueues the required scripts.
 *
 * @return void
 */
function halt_load_scripts() {
	$js_dir = HALT_PLUGIN_URL . 'assets/js/';

	wp_enqueue_script( 'jquery' );

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_script( 'halt-scripts', $js_dir . 'halt-scripts' . $suffix . '.js', array( 'jquery' ), HALT_VERSION, true );

	wp_localize_script( 'halt-scripts', 'halt_vars', array(
		'ajaxurl'    => admin_url('admin-ajax.php'),
		'ajax_nonce' => wp_create_nonce( 'halt_ajax_nonce' )
	) );
}
add_action( 'wp_enqueue_scripts', 'halt_load_scripts' );

/**
 * Register Styles
 *
 * Checks the styles option and hooks the required filter.
 *
 * @since 1.0
 * @global $halt_options
 * @return void
 */
function halt_register_styles() {
	global $halt_options;
	$css_dir = HALT_PLUGIN_URL . 'assets/css/';
	$js_dir  = HALT_PLUGIN_URL . 'assets/js/';

	if ( isset( $halt_options['disable_styles'] ) ) {
		return;
	}

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	$file = 'halt' . $suffix . '.css';

	wp_enqueue_style( 'halt-styles', $css_dir . $file, array(), HALT_VERSION );

}
add_action( 'wp_enqueue_scripts', 'halt_register_styles' );

/**
 * Load Admin Scripts
 *
 * Enqueues the required admin scripts.
 *
 * @param string $hook Page hook
 * @return void
 */
function halt_load_admin_scripts( $hook ) {
	global $post;

	$css_dir = HALT_PLUGIN_URL . 'assets/css/';
	$js_dir  = HALT_PLUGIN_URL . 'assets/js/';

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	$halt_pages = array( 'index.php' );
	$halt_cpt 	= apply_filters( 'halt_load_scripts_for_these_types', array( 'article', 'tickets' ) );

	if ( ! in_array( $hook, $halt_pages ) && ! is_object( $post ) )
		return;

	if ( is_object( $post ) && ! in_array( $post->post_type, $halt_cpt ) )
		return;

	wp_enqueue_style( 'halt-admin', $css_dir . 'halt-admin' . $suffix . '.css', HALT_VERSION );

}
add_action( 'admin_enqueue_scripts', 'halt_load_admin_scripts', 100 );


/**
 * Adds Halt Version to the <head> tag
 *
 * @since 1.0
 * @return void
*/
function halt_version_in_header(){
	// Newline on both sides to avoid being in a blob
	echo '<meta name="generator" content="Halt v' . HALT_VERSION . '" />' . "\n";
}
add_action( 'wp_head', 'halt_version_in_header' );
