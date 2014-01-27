<?php
/**
 * Misc Functions.
 *
 * @package  	Halt
 * @subpackage  Functions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Convert an object to an associative array.
 *
 * Can handle multidimensional arrays.
 *
 * @param unknown $data
 * @return array
 */
function stag_object_to_array( $data ) {
	if ( is_array( $data ) || is_object( $data ) ) {
		$result = array();
		foreach ( $data as $key => $value ) {
			$result[ $key ] = stag_object_to_array( $value );
		}
		return $result;
	}
	return $data;
}

/**
 * Get File Extension.
 *
 * Returns the file extension of a filename.
 *
 * @param unknown $str File name
 * @return mixed File extension
 */
function halt_get_file_extension( $str ) {
	$parts = explode( '.', $str );
	return end( $parts );
}
