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
 * Hooks Halt actions, when present in the $_GET superglobal. Every halt_action
 * present in $_GET is called using WordPress's do_action function. These
 * functions are called on init.
 *
 * @since 1.0
 * @return void
*/
function halt_get_actions() {
	if ( isset( $_GET['halt_action'] ) ) {
		do_action( 'halt_' . $_GET['halt_action'], $_GET );
	}
}
add_action( 'init', 'halt_get_actions' );

/**
 * Hooks Halt actions, when present in the $_POST superglobal. Every halt_action
 * present in $_POST is called using WordPress's do_action function. These
 * functions are called on init.
 *
 * @since 1.0
 * @return void
*/
function halt_post_actions() {
	if ( isset( $_POST['halt_action'] ) ) {
		do_action( 'halt_' . $_POST['halt_action'], $_POST );
	}
}
add_action( 'init', 'halt_post_actions' );
