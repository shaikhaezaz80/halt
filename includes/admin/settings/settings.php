<?php
/**
 * Admin Options Page
 *
 * @package     Halt
 * @subpackage  Admin Options Page
 * @author 		Ram Ratan Maurya
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

function halt_options_page() {
	global $halt_options;

	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';

	ob_start(); ?>

	<div class="wrap help-center">
		<div class="icon32 icon-dashboard" id="icon-halt"><br /></div>
		<h2 class="nav-tab-wrapper">
			<a href="<?php echo add_query_arg('tab', 'general', remove_query_arg('settings-updated')); ?>" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General', 'halt'); ?></a>
			<a href="<?php echo add_query_arg('tab', 'article', remove_query_arg('settings-updated')); ?>" class="nav-tab <?php echo $active_tab == 'article' ? 'nav-tab-active' : ''; ?>"><?php _e('Article', 'halt'); ?></a>
		</h2>

		<div id="tab_container">
			<form method="post" action="options.php">
				<?php
				if( $active_tab == 'general' ) {
					settings_fields( 'halt_settings_general' );
					do_settings_sections( 'halt_settings_general' );
				} elseif ( $active_tab == 'article' ) {
					settings_fields( 'halt_settings_article' );
					do_settings_sections( 'halt_settings_article' );
				}

				submit_button();
				?>
			</form>
		</div><!-- #tab_container -->
	</div><!-- .wrap -->

	<?php
	echo ob_get_clean();
}
