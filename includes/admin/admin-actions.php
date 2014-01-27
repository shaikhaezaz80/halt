<?php
/**
 * Admin Actions
 *
 * @package     Halt
 * @subpackage  Admin/Actions
 * @copyright   Copyright (c) 2014, Ram Ratan Maurya
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Processes all Halt actions sent via POST and GET by looking for the 'halt-action'
 * request and running do_action() to call the function
 *
 * @return void
 */
function halt_process_actions() {
	if ( isset( $_POST['halt-action'] ) ) {
		do_action( 'halt_' . $_POST['halt-action'], $_POST );
	}

	if ( isset( $_GET['halt-action'] ) ) {
		do_action( 'halt_' . $_GET['halt-action'], $_GET );
	}
}
add_action( 'admin_init', 'halt_process_actions' );
