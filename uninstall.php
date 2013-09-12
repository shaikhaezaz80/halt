<?php
/**
 * Uninstall Halt
 *
 * @package     Halt
 * @subpackage  Uninstall
 * @author 		Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

// Load Halt file
include_once( 'halt.php' );

/** Delete all the Plugin Options */
delete_option( 'halt_settings_general' );
