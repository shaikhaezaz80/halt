<?php
/**
 * Admin Options Page
 *
 * @package     CHC
 * @subpackage  Admin Options Page
 * @copyright   Copyright (c) 2013, Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Options Page
 *
 * Renders the options page contents.
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

function chc_options_page() {
	global $chc_options;

	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';

	ob_start(); ?>

	<div class="wrap">
		<h2 class="nav-tab-wrapper">
			<a href="<?php echo add_query_arg('tab', 'general', remove_query_arg('settings-updated')); ?>" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General', 'chc'); ?></a>
			<a href="<?php echo add_query_arg('tab', 'knowledgebase', remove_query_arg('settings-updated')); ?>" class="nav-tab <?php echo $active_tab == 'knowledgebase' ? 'nav-tab-active' : ''; ?>"><?php _e('Knowledgebase', 'chc'); ?></a>
		</h2>

		<div id="tab_container">
			<form method="post" action="options.php">
				<?php
				if( $active_tab == 'general' ) {
					settings_fields( 'chc_settings_general' );
					do_settings_sections( 'chc_settings_general' );
				} elseif ( $active_tab == 'knowledgebase' ) {
					settings_fields( 'chc_settings_knowledgebase' );
					do_settings_sections( 'chc_settings_knowledgebase' );
				}

				submit_button();
				?>
			</form>
		</div><!-- #tab_container -->
	</div><!-- .wrap -->

	<?php
	echo ob_get_clean();
}
