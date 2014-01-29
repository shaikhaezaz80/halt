<?php
/**
 * Tools
 *
 * @package     Halt
 * @subpackage  Admin/Tools
 * @author   	Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shows the tools panel which contains Halt-specific tools including the
 * built-in import/export system.
 *
 * @return void
 */
function halt_tools_page() {
?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php _e( 'Tools', 'halt' ) ?></h2>
		<div class="metabox-holder">
			<?php do_action( 'halt_tools_before' ); ?>
			<div class="postbox">
				<h3><span><?php _e( 'Export Settings', 'halt' ); ?></span></h3>
				<div class="inside">
					<p><?php _e( 'Export the Halt settings for this site as a .json file. This allows you to easily import the configuration into another site.', 'halt' ); ?></p>
					<form method="post" action="<?php echo admin_url( 'admin.php?page=halt-tools' ); ?>">
						<p><input type="hidden" name="halt-action" value="export_settings" /></p>
						<p>
							<?php wp_nonce_field( 'halt_export_nonce', 'halt_export_nonce' ); ?>
							<?php submit_button( __( 'Export', 'halt' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
			<div class="postbox">
				<h3><span><?php _e( 'Import Settings', 'halt' ); ?></span></h3>
				<div class="inside">
					<p><?php _e( 'Import the Halt settings from a .json file. This file can be obtained by exporting the settings on another site using the form above.', 'halt' ); ?></p>
					<form method="post" enctype="multipart/form-data" action="<?php echo admin_url( 'admin.php?page=halt-tools' ); ?>">
						<p>
							<input type="file" name="import_file"/>
						</p>
						<p>
							<input type="hidden" name="halt-action" value="import_settings" />
							<?php wp_nonce_field( 'halt_import_nonce', 'halt_import_nonce' ); ?>
							<?php submit_button( __( 'Import', 'halt' ), 'secondary', 'submit', false ); ?>
						</p>
					</form>
				</div><!-- .inside -->
			</div><!-- .postbox -->
			<?php do_action( 'halt_tools_after' ); ?>
		</div><!-- .metabox-holder -->
	</div><!-- .wrap -->
<?php
}

/**
 * Process a settings export that generates a .json file of the Halt settings
 *
 * @return 	void
 */
function halt_process_settings_export() {

	if( empty( $_POST['halt_export_nonce'] ) )
		return;

	if( ! wp_verify_nonce( $_POST['halt_export_nonce'], 'halt_export_nonce' ) )
		return;

	if( ! current_user_can( 'manage_halt' ) )
		return;

	$settings = array();
	$settings = get_option( 'halt_settings' );

	// ignore_user_abort( true );

	nocache_headers();
	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=halt-settings-export-' . date( 'm-d-Y' ) . '.json' );
	header( "Expires: 0" );

	echo json_encode( $settings );
	exit;
}
add_action( 'halt_export_settings', 'halt_process_settings_export' );


/**
 * Process a settings import from a json file
 *
 * @return void
 */
function halt_process_settings_import() {

	if( empty( $_POST['halt_import_nonce'] ) )
		return;

	if( ! wp_verify_nonce( $_POST['halt_import_nonce'], 'halt_import_nonce' ) )
		return;

	if( ! current_user_can( 'manage_halt' ) )
		return;

    if( halt_get_file_extension( $_FILES['import_file']['name'] ) != 'json' ) {
        wp_die( __( 'Please upload a valid .json file', 'halt' ) );
    }

	$import_file = $_FILES['import_file']['tmp_name'];

	if( empty( $import_file ) ) {
		wp_die( __( 'Please upload a file to import', 'halt' ) );
	}

	// Retrieve the settings from the file and convert the json object to an array
	$settings = halt_object_to_array( json_decode( file_get_contents( $import_file ) ) );

	update_option( 'halt_settings', $settings );

	wp_safe_redirect( admin_url( 'admin.php?page=halt-tools&halt-message=settings-imported' ) ); exit;

}
add_action( 'halt_import_settings', 'halt_process_settings_import' );
