<?php
/**
 * System Info
 *
 * These are functions are used for exporting data from Halt.
 *
 * @package     Halt
 * @subpackage  Admin/System
 * @author 		Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * System Info
 *
 * @global object $wpdb Used to query the database using the WordPress Database API
 * @global array $halt_options Array of all the Halt Options
 * @return void
 */
function halt_system_info() {
	global $wpdb, $halt_options;

	if ( get_bloginfo( 'version' ) < '3.4' ) {
		$theme_data = get_theme_data( get_stylesheet_directory() . '/style.css' );
		$theme      = $theme_data['Name'] . ' ' . $theme_data['Version'];
	} else {
		$theme_data = wp_get_theme();
		$theme      = $theme_data->Name . ' ' . $theme_data->Version;
	}

	$host = false;
	if( defined( 'WPE_APIKEY' ) ) {
		$host = 'WP Engine';
	} elseif( defined( 'PAGELYBIN' ) ) {
		$host = 'Pagely';
	}

	?>

	<div class="wrap">
		<h2><?php _e( 'System Information', 'halt' ) ?></h2><br/>

		<table class="wc_status_table widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="2"><?php _e( 'Environment', 'halt' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?php _e( 'Home URL','halt' ); ?>:</td>
					<td><?php echo home_url(); ?></td>
				</tr>
				<tr>
					<td><?php _e( 'Site URL','halt' ); ?>:</td>
					<td><?php echo site_url(); ?></td>
				</tr>
				<tr>
					<td><?php _e( 'WC Version','halt' ); ?>:</td>
					<td><?php echo esc_html( HALT_VERSION ); ?></td>
				</tr>
				<tr>
					<td><?php _e( 'WP Version','halt' ); ?>:</td>
					<td><?php bloginfo('version'); ?></td>
				</tr>
				<tr>
					<td><?php _e( 'WP Multisite Enabled','halt' ); ?>:</td>
					<td><?php if ( is_multisite() ) echo __( 'Yes', 'halt' ); else echo __( 'No', 'halt' ); ?></td>
				</tr>
				<tr>
					<td><?php _e( 'Web Server Info','halt' ); ?>:</td>
					<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
				</tr>
				<tr>
					<td><?php _e( 'PHP Version','halt' ); ?>:</td>
					<td><?php if ( function_exists( 'phpversion' ) ) echo esc_html( phpversion() ); ?></td>
				</tr>
				<tr>
					<td><?php _e( 'MySQL Version','halt' ); ?>:</td>
					<td><?php if ( function_exists( 'mysql_get_server_info' ) ) echo esc_html( mysql_get_server_info() ); ?></td>
				</tr>
			</tbody>
		</table>
	</div>

	<?php
}
