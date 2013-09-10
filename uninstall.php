<?php
/**
 * Uninstall Customer Help Center
 *
 * @package     CHC
 * @subpackage  Uninstall
 * @copyright   Copyright (c) 2013, Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.4.3
 */

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

// Load CHC file
include_once( 'customer-help-center.php' );

/** Delete all the Plugin Options */
delete_option( 'chc_settings_general' );