<?php
/**
 * Halt Article Functions
 *
 * Functions available on both the front-end and admin.
 *
 * @author 		Ram Ratan Maurya
 * @category 	Core
 * @package 	Halt/Functions
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Article vote
 * @return void
 */
function halt_article_votes_output() {

	if( ! is_singular('article') ) return;

	$upvotes   = (int) get_post_meta( get_the_ID(), '_article_upvotes', true );
	$downvotes = (int) get_post_meta( get_the_ID(), '_article_downvotes', true );

	?>
	<section class="article-vote <?php if ( isset( $_COOKIE['article_vote_' . get_the_ID()] ) ) echo 'voted'; ?>" data-article-id="<?php echo get_the_ID(); ?>">
		<p>
			<a href="#" data-vote-type="positive" title="<?php esc_attr_e( 'Yes', 'halt' ); ?>" class="upvote"><i class="hicon hicon-thumbs-up"></i><span class="count"><?php echo number_format_i18n( $upvotes ); ?></span></a>
			<a href="#" data-vote-type="negative" title="<?php esc_attr_e( 'No', 'halt' ); ?>" class="downvote"><i class="hicon hicon-thumbs-down"></i><span class="count"><?php echo number_format_i18n( $downvotes ); ?></span></a>
			<?php _e( 'Was this article useful?', 'halt' ); ?>
		</p>
	</section>
	<?php
}
add_action( 'halt_after_single_article', 'halt_article_votes_output' );

/**
 * Set Default Article Category
 *
 * @param  integer $post_id Post ID
 * @return void
 * @todo It prevents other categories to be set to post, come over a better solution
 *       once we have enough data to install on first installation
 */
function halt_set_article_default_category( $post_id ) {
	if( ! wp_is_post_revision( $post_id ) ) {
		$cat_to_add = array('general');
		wp_set_object_terms( $post_id, $cat_to_add, 'article_cat' );
	}
}
// add_action( 'publish_article', 'halt_set_article_default_category' );
