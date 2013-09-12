<?php
/**
 * Scripts
 *
 * @package     Halt
 * @subpackage  Functions
 * @author 		Ram Ratan Maurya
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
 * @global $halt_options
 * @global $post
 * @return void
 */
function halt_load_scripts() {
	global $halt_options, $post;

	$js_dir = HALT_PLUGIN_URL . 'assets/js/';

	wp_enqueue_script( 'jquery' );

	define('SCRIPT_DEBUG', true);

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
}
// add_action( 'wp_enqueue_scripts', 'halt_load_scripts' );
	
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
