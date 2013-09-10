<?php
/**
 * The template for displaying knowledgebase content in the single-knowledgebase.php template
 *
 * Override this template by copying it to yourtheme/chc/content-single-knowledgebase.php
 *
 * @author 		Ram Ratan Maurya
 * @package 	CHC/Templates
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * chc_before_single_knowledgebase hook
	 *
	 */
	 do_action( 'chc_before_single_knowledgebase' );
?>

<article id="kb-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header>
	
	<?php if( is_single() ) : ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php endif; ?>

</article><!-- #kb-<?php the_ID(); ?> -->

<?php do_action( 'chc_after_single_knowledgebase' ); ?>
