<?php
/**
 * Mime Types.
 *
 * @package     Halt
 * @subpackage  Functions
 * @author 		Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Allowed Mime Types.
 *
 * @param array $existing_mimes A list of all the existing MIME types
 * @return array $existing_mimes A list of all the new MIME types appended
 */
function halt_allowed_mime_types( $existing_mimes ) {
	$existing_mimes['zip']  = 'application/zip';
	$existing_mimes['psd']  = 'image/photoshop';

	return $existing_mimes;
}
add_filter( 'upload_mimes', 'halt_allowed_mime_types' );
