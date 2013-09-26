<?php
/**
 * Halt Dashboard Widgets
 *
 * @package     Halt
 * @subpackage  Admin/Dashboard
 * @author   	Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers the dashboard widgets
 *
 * @since 1.0
 * @return void
 */
function halt_register_dashboard_widgets() {
	if ( current_user_can( apply_filters( 'halt_dashboard_stats_cap', 'edit_pages' ) ) ) {
		wp_add_dashboard_widget( 'halt_dashboard_stats', __('Halt Right now', 'halt'), 'halt_init_dashboard_widgets' );
	}
}
add_action( 'wp_dashboard_setup', 'halt_register_dashboard_widgets', 0 );


function halt_init_dashboard_widgets() {
	global $halt_options;

	$kb_count = wp_count_posts( 'article' );
	$kb_cat_count  = wp_count_terms( 'article_cat' );
	$kb_tag_count  = wp_count_terms( 'article_tag' );

	?>

	<div class="table table_help_content">
		<p class="sub halt_sub"><?php _e( 'Halt Stats', 'halt' ); ?></p>
		<table>
			<tr class="first">
				<?php
					$num  = number_format_i18n( $kb_count->publish );
					$text = _n( 'Article', 'Articles', intval( $kb_count->publish ), 'halt' );
					$link = add_query_arg( array( 'post_type' => 'article' ), get_admin_url( null, 'edit.php' ) );
					$num  = '<a href="' . esc_url($link ) . '">' . esc_html( $num )  . '</a>';
					$text = '<a href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>';
				?>
				<td class="first b b-article"><?php echo $num; ?></td>
				<td class="t article"><?php echo $text; ?></td>
			</tr>

			<tr>
				<?php
					$num  = number_format_i18n( $kb_cat_count );
					$text = _n( 'Article Category', 'Article Categories', $kb_cat_count, 'halt' );
					$link = add_query_arg( array( 'taxonomy' => 'article_cat', 'post_type' => 'article' ), get_admin_url( null, 'edit-tags.php' ) );
					$num  = '<a href="' . esc_url($link ) . '">' . esc_html( $num )  . '</a>';
					$text = '<a href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>';
				?>
				<td class="first b b-article_cats"><?php echo $num; ?></td>
				<td class="t article_cats"><?php echo $text; ?></td>
			</tr>

			<tr>

				<?php
					$num  = number_format_i18n( $kb_tag_count );
					$text = _n( 'Article Tag', 'Article Tags', $kb_tag_count, 'halt' );
					$link = add_query_arg( array( 'taxonomy' => 'article_tag', 'post_type' => 'article' ), get_admin_url( null, 'edit-tags.php' ) );
					$num  = '<a href="' . esc_url($link ) . '">' . esc_html( $num )  . '</a>';
					$text = '<a href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>';
				?>

				<td class="first b b-article_tags"><?php echo $num; ?></td>
				<td class="t article_tags"><?php echo $text; ?></td>
			</tr>
		</table>
	</div>

	<?php
}