<?php
/**
 * The template for displaying article content in the single-article.php template
 *
 * Override this template by copying it to yourtheme/halt/content-single-article.php
 *
 * @author 		Ram Ratan Maurya
 * @package 	Halt/Templates
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * halt_before_single_article hook
	 *
	 */
	 do_action( 'halt_before_single_article' );
?>

<article id="article-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php if( is_single() ) : ?>
		<time class="updated" datetime="<?php esc_attr_e( get_the_modified_date( 'c' ) ); ?>"><?php _e( 'Last Updated:', 'halt' ); ?> <?php the_modified_date('F j, Y h:iA T'); ?></time>
		<?php endif; ?>
	</header>
	
	<?php if( is_single() ) : ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php endif; ?>

</article><!-- #article-<?php the_ID(); ?> -->

<?php
	/**
	 * halt_after_single_article hook
	 *
	 */
	do_action( 'halt_after_single_article' );
?>
