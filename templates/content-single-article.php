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
	</header>
	
	<?php if( is_single() ) : ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php endif; ?>

</article><!-- #article-<?php the_ID(); ?> -->

<?php do_action( 'halt_after_single_article' ); ?>
