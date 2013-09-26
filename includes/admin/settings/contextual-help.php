<?php
/**
 * Contextual Help
 *
 * @package     Halt
 * @subpackage  Admin/Settings
 * @author 		Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Settings contextual help.
 *
 * @access      private
 * @since       1.0
 * @return      void
 */
function my_plugin_help($contextual_help, $screen_id, $screen) {
	if ( $screen_id == 'toplevel_page_halt-settings' ) {

		$screen->set_help_sidebar(
			'<p><strong>' . sprintf( __( 'For more information:', 'halt' ) . '</strong></p>' .
			'<p>' . sprintf( __( 'Visit the <a href="%s">documentation</a> on the Halt website.', 'halt' ), esc_url( 'https://halt.io/documentation/' ) ) ) . '</p>' .
			'<p>' . sprintf(
						__( '<a href="%s">Post an issue</a> on <a href="%s">GitHub</a>. View <a href="%s">extensions</a> or <a href="%s">themes</a>.', 'halt' ),
						esc_url( 'https://github.com/mauryaratan/halt/issues' ),
						esc_url( 'https://github.com/mauryaratan/halt' ),
						esc_url( 'https://halt.io/extensions/' ),
						esc_url( 'https://halt.io/themes/' )
					) . '</p>'
		);

		$screen->add_help_tab( array(
			'id'	    => 'halt-settings-general',
			'title'	    => __( 'General', 'halt' ),
			'content'	=> '<p>' . __( 'This screen provides the most basic settings for configuring customer help center.', 'halt' ) . '</p>'
		) );

		$screen->add_help_tab( array(
			'id'	    => 'halt-settings-article',
			'title'	    => __( 'Article', 'halt' ),
			'content'	=> '<p>' . __( 'This screen provides settings for articles.', 'halt' ) . '</p>'
		) );

	}
	
	return $contextual_help;
}
add_filter('contextual_help', 'my_plugin_help', 10, 3);
