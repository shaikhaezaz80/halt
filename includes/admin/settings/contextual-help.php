<?php
/**
 * Contextual Help
 *
 * @package     CHC
 * @subpackage  Admin/Settings
 * @copyright   Copyright (c) 2013, Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Settings contextual help.
 *
 * @access      private
 * @since       1.4
 * @return      void
 */
function my_plugin_help($contextual_help, $screen_id, $screen) {
	if ( $screen_id == 'toplevel_page_chc-settings' ) {

		$screen->set_help_sidebar(
			'<p><strong>' . sprintf( __( 'For more information:', 'chc' ) . '</strong></p>' .
			'<p>' . sprintf( __( 'Visit the <a href="%s">documentation</a> on the Easy Digital Downloads website.', 'chc' ), esc_url( 'https://easydigitaldownloads.com/documentation/' ) ) ) . '</p>' .
			'<p>' . sprintf(
						__( '<a href="%s">Post an issue</a> on <a href="%s">GitHub</a>. View <a href="%s">extensions</a> or <a href="%s">themes</a>.', 'chc' ),
						esc_url( 'https://github.com/easydigitaldownloads/Easy-Digital-Downloads/issues' ),
						esc_url( 'https://github.com/easydigitaldownloads/Easy-Digital-Downloads' ),
						esc_url( 'https://easydigitaldownloads.com/extensions/' ),
						esc_url( 'https://easydigitaldownloads.com/themes/' )
					) . '</p>'
		);

		$screen->add_help_tab( array(
			'id'	    => 'chc-settings-general',
			'title'	    => __( 'General', 'chc' ),
			'content'	=> '<p>' . __( 'This screen provides the most basic settings for configuring customer help center.', 'chc' ) . '</p>'
		) );

	}
	
	return $contextual_help;
}
add_filter('contextual_help', 'my_plugin_help', 10, 3);
