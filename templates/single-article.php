<?php
/**
 * The Template for displaying all single article.
 * 
 * Override this template by copying it to yourtheme/halt/single-article.php
 * 
 * @package 	Halt/Templates
 * @since 		1.0
 * @author 		Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('article'); ?>

	<?php
		/**
		 * halt_article_before_main_content hook
		 */
		do_action('halt_article_before_main_content');
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php halt_get_template_part( 'content', 'single-article' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * halt_article_after_main_content hook
		 *
		 */
		do_action('halt_article_after_main_content');
	?>

	<?php
		/**
		 * halt_article_sidebar hook
		 *
		 */
		do_action('halt_article_sidebar');
	?>

<?php get_footer('article'); ?>
