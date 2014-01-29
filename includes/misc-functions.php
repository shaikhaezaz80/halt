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
function halt_object_to_array( $data ) {
	if ( is_array( $data ) || is_object( $data ) ) {
		$result = array();
		foreach ( $data as $key => $value ) {
			$result[ $key ] = halt_object_to_array( $value );
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

/**
 * Marks a function as deprecated and informs when it has been used.
 *
 * There is a hook halt_deprecated_function_run that will be called that can be used
 * to get the backtrace up to what file and function called the deprecated
 * function.
 *
 * The current behavior is to trigger a user error if WP_DEBUG is true.
 *
 * This function is to be used in every function that is deprecated.
 *
 * @uses do_action() Calls 'halt_deprecated_function_run' and passes the function name, what to use instead,
 *   and the version the function was deprecated in.
 * @uses apply_filters() Calls 'halt_deprecated_function_trigger_error' and expects boolean value of true to do
 *   trigger or false to not trigger error.
 *
 * @param string  $function    The function that was called
 * @param string  $version     The version of WordPress that deprecated the function
 * @param string  $replacement Optional. The function that should have been called
 * @param array   $backtrace   Optional. Contains stack backtrace of deprecated function
 */
function _halt_deprecated_function( $function, $version, $replacement = null, $backtrace = null ) {
	do_action( 'halt_deprecated_function_run', $function, $replacement, $version );

	// Allow plugin to filter the output error trigger
	if ( WP_DEBUG && apply_filters( 'halt_deprecated_function_trigger_error', true ) ) {
		if ( function_exists( '__' ) ) {
			if ( ! is_null( $replacement ) )
				trigger_error( sprintf( __('%1$s is <strong>deprecated</strong> since Halt version %2$s! Use %3$s instead.'), $function, $version, $replacement ) );
			else
				trigger_error( sprintf( __('%1$s is <strong>deprecated</strong> since Halt version %2$s with no alternative available.'), $function, $version ) );
		} else {
			if ( ! is_null( $replacement ) )
				trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since Halt version %2$s! Use %3$s instead.', $function, $version, $replacement ) );
			else
				trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since Halt version %2$s with no alternative available.', $function, $version ) );
		}
	}
}
