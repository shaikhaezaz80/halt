<?php
/**
 * Dashboard Widgets
 *
 * @package     CHC
 * @subpackage  Admin/Dashboard
 * @copyright   Copyright (c) 2013, Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       0.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers the dashboard widgets
 *
 * @since 1.2.2
 * @return void
 */
function chc_register_dashboard_widgets() {
	if ( current_user_can( apply_filters( 'chc_dashboard_stats_cap', 'edit_pages' ) ) ) {
		wp_add_dashboard_widget( 'chc_dashboard_stats', __('Customer Help Center Right now', 'chc'), 'chc_init_dashboard_widgets' );
	}
}
add_action('wp_dashboard_setup', 'chc_register_dashboard_widgets', 0 );


function chc_init_dashboard_widgets() {
	global $chc_options;

	$kb_count = wp_count_posts( 'knowledgebase' );
	$kb_cat_count  = wp_count_terms( 'knowledgebase_category' );
	$kb_tag_count  = wp_count_terms( 'knowledgebase_tags' );

	?>

	<div class="table table_help_content">
		<p class="sub chc_sub"><?php _e( 'Help Center Stats', 'chc' ); ?></p>
		<table>
			<tr class="first">
				<?php
					$num  = number_format_i18n( $kb_count->publish );
					$text = _n( 'Knowledgebase Article', 'Knowledgebase Articles', intval( $kb_count->publish ), 'chc' );
					$link = add_query_arg( array( 'post_type' => 'knowledgebase' ), get_admin_url( null, 'edit.php' ) );
					$num  = '<a href="' . esc_url($link ) . '">' . esc_html( $num )  . '</a>';
					$text = '<a href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>';
				?>
				<td class="first b b-knowledgebase"><?php echo $num; ?></td>
				<td class="t knowledgebase"><?php echo $text; ?></td>
			</tr>

			<tr>
				<?php
					$num  = number_format_i18n( $kb_cat_count );
					$text = _n( 'Knowledgebase Category', 'Knowledgebase Categories', $kb_cat_count, 'chc' );
					$link = add_query_arg( array( 'taxonomy' => 'knowledgebase_category', 'post_type' => 'knowledgebase' ), get_admin_url( null, 'edit-tags.php' ) );
					$num  = '<a href="' . esc_url($link ) . '">' . esc_html( $num )  . '</a>';
					$text = '<a href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>';
				?>
				<td class="first b b-knowledgebase_cats"><?php echo $num; ?></td>
				<td class="t knowledgebase_cats"><?php echo $text; ?></td>
			</tr>

			<tr>

				<?php
					$num  = number_format_i18n( $kb_tag_count );
					$text = _n( 'Knowledgebase Tag', 'Knowledgebase Tags', $kb_tag_count, 'chc' );
					$link = add_query_arg( array( 'taxonomy' => 'knowledgebase_tags', 'post_type' => 'knowledgebase' ), get_admin_url( null, 'edit-tags.php' ) );
					$num  = '<a href="' . esc_url($link ) . '">' . esc_html( $num )  . '</a>';
					$text = '<a href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>';
				?>

				<td class="first b b-knowledgebase_tags"><?php echo $num; ?></td>
				<td class="t knowledgebase_tags"><?php echo $text; ?></td>
			</tr>
		</table>
	</div>

	<?php
}
