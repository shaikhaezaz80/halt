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
 * @global array $halt_options Array of all Halt options.
 *
 * @return void
 */
function halt_load_scripts() {
	global $halt_options;

	$js_dir = HALT_PLUGIN_URL . 'assets/js/';

	wp_enqueue_script( 'jquery' );

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_script( 'halt-scripts', $js_dir . 'halt-scripts' . $suffix . '.js', array( 'jquery' ), HALT_VERSION, true );
	wp_register_script( 'jquery-cookie', $js_dir . 'jquery-cookie/jquery.cookie' . $suffix . '.js', array( 'jquery' ), '1.4.0', true );

	if( is_single() && 'article' == get_post_type() && !is_user_logged_in() ) {
		wp_enqueue_script( 'jquery-cookie' );
	}

	wp_localize_script( 'halt-scripts', 'halt_vars', array(
		'ajaxurl'            => admin_url('admin-ajax.php'),
		'ajax_nonce'         => wp_create_nonce( 'halt_ajax_nonce' ),
		'logged_in'          => is_user_logged_in() ? 'true' : 'false',
		'error_message'      => __( 'Sorry, there was a problem processing your request.', 'halt' ),
		'already_voted_text' => ( isset( $halt_options['already_voted_text'] ) ) ? $halt_options['already_voted_text'] : __( 'You have already voted!', 'halt' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'halt_load_scripts' );

/**
 * Register Styles
 *
 * Checks the styles option and hooks the required filter.
 *
 * @since 1.0
 * @global $halt_options Array of all Halt Options.
 * @return void
 */
function halt_register_styles() {
	global $halt_options;

	$css_dir = HALT_PLUGIN_URL . 'assets/css/';

	if ( isset( $halt_options['disable_styles'] ) ) {
		return;
	}

	wp_enqueue_style( 'halt-styles', $css_dir . 'halt.css', array(), HALT_VERSION );
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

	wp_enqueue_style( 'halt-admin-menu-styles', $css_dir . 'halt-menu.css', HALT_VERSION );

	$halt_pages = array( 'index.php' );
	$halt_cpt 	= apply_filters( 'halt_load_scripts_for_these_types', array( 'article', 'tickets' ) );

	if ( ! in_array( $hook, $halt_pages ) && ! is_object( $post ) )
		return;

	if ( is_object( $post ) && ! in_array( $post->post_type, $halt_cpt ) )
		return;

	wp_enqueue_style( 'halt-admin', $css_dir . 'halt-admin.css', HALT_VERSION );

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
