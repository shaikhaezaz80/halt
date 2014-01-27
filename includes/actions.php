<?php
/**
 * Front-end Actions
 *
 * @package     Halt
 * @subpackage  Functions
 * @copyright   Copyright (c) 2014, Ram Ratan Maurya
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Processes all Halt actions sent via POST and GET by looking for the 'halt_action'
 * request and running do_action() to call the function
 *
 * @return void
*/
function halt_get_post_actions() {
	if ( isset( $_GET['halt_action'] ) ) {
		do_action( 'halt_' . $_GET['halt_action'], $_GET );
	}

	if ( isset( $_POST['halt_action'] ) ) {
		do_action( 'halt_' . $_POST['halt_action'], $_POST );
	}
}
add_action( 'init', 'halt_get_post_actions' );
