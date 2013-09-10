<?php
/**
 * The Template for displaying all single knowledgebase.
 * 
 * Override this template by copying it to yourtheme/chc/single-knowledgebase.php
 * 
 * @package 	CHC/Templates
 * @since 		1.0
 * @copyright   Copyright (c) 2013, Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('knowledgebase'); ?>

	<?php
		/**
		 * chc_knowledgebase_before_main_content hook
		 */
		do_action('chc_knowledgebase_before_main_content');
	?>

		<?php if( have_posts() ) : ?>

			<?php while( have_posts() ) : the_post(); ?>

				<?php chc_get_template_part( 'content', 'single-knowledgebase' ); ?>
				
			<?php endwhile; ?>
			
		<?php endif; ?>

	<?php
		/**
		 * chc_knowledgebase_after_main_content hook
		 *
		 */
		do_action('chc_knowledgebase_after_main_content');
	?>

	<?php
		/**
		 * chc_knowledgebase_sidebar hook
		 *
		 */
		do_action('chc_knowledgebase_sidebar');
	?>

<?php get_footer(); ?>
