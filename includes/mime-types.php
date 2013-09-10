<?php
/**
 * Mime Types
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
 * Allowed Mime Types
 *
 * @since 1.0
 * @param array $$existing_mimes A list of all the existing MIME types
 * @return array $$existing_mimes A list of all the new MIME types appended
 */
function chc_allowed_mime_types( $existing_mimes ) {
	$existing_mimes['zip']  = 'application/zip';
	$existing_mimes['psd']  = 'image/photoshop';

	return $existing_mimes;
}
add_filter( 'upload_mimes', 'chc_allowed_mime_types' );