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
 *
 * @global array $halt_options Array of all Halt options.
 * @return void
 */
function halt_article_votes_output() {
	global $halt_options;

	if( ! is_singular('article') ) return;

	// Return if 'Disable Voting' is checked under Settings > Article.
	if( isset( $halt_options['disable_article_voting'] ) ) return;

	$upvotes   = (int) get_post_meta( get_the_ID(), '_article_upvotes', true );
	$downvotes = (int) get_post_meta( get_the_ID(), '_article_downvotes', true );

	$user_id   = get_current_user_id();
	$post_id   = get_the_ID();

	?>

	<section class="article-vote<?php if ( halt_has_user_already_voted( $user_id, $post_id ) ) echo ' voted'; ?>" data-article-id="<?php echo esc_attr( get_the_ID() ); ?>" data-user-id="<?php echo esc_attr( $user_id ); ?>">
		<a href="#" data-vote-type="upvote" title="<?php esc_attr_e( 'Yes', 'halt' ); ?>" class="upvote">
			<i class="hicon hicon-thumbs-up"></i>
			<span class="count"><?php echo number_format_i18n( $upvotes ); ?></span>
		</a>

		<a href="#" data-vote-type="downvote" title="<?php esc_attr_e( 'No', 'halt' ); ?>" class="downvote">
			<i class="hicon hicon-thumbs-down"></i>
			<span class="count"><?php echo number_format_i18n( $downvotes ); ?></span>
		</a>
		<?php

			if ( ! halt_has_user_already_voted( $user_id, $post_id ) ) {
				echo ( isset( $halt_options['article_vote_text'] ) && $halt_options['article_vote_text'] != '' ) ? $halt_options['article_vote_text'] : __( 'Was this article useful?', 'halt' );
			} else {
				echo ( isset( $halt_options['already_voted_text'] ) && $halt_options['already_voted_text'] != '' ) ? $halt_options['already_voted_text'] : __( 'You have already voted!', 'halt' );
			}

		?>
	</section><!-- .article-vote -->
	<?php
}
add_action( 'halt_after_single_article', 'halt_article_votes_output' );

/**
 * Check if user has already voted for the article.
 *
 * @param  int $user_id User ID.
 * @param  int $post_id Post ID.
 *
 * @return bool True if user has already voted, else false.
 */
function halt_has_user_already_voted( $user_id, $post_id ) {
	$voted = get_user_option( 'articles_voted', $user_id );

	if ( is_array( $voted ) && in_array( $post_id, $voted ) ) {
		return true;
	}

	if( isset( $_COOKIE['article-vote-' . $post_id ] ) ) {
		return true;
	}

	return false;
}

/**
 * Add the Article ID to users meta so they can't vote again.
 *
 * @param  int $user_id User ID.
 * @param  int $post_id Post ID.
 *
 * @return void
 */
function halt_add_user_vote( $user_id, $post_id ) {
	$voted = get_user_option( 'articles_voted', $user_id );

	if ( is_array( $voted ) ) {
		$voted[] = $post_id;
	} else {
		$voted = array( $post_id );
	}
	update_user_option( $user_id, 'articles_voted', $voted );
}

function halt_add_article_vote( $user_id, $post_id, $type ) {
	if ( $type != ( 'upvote' || 'downvote' ) ) {
		return false;
	}

	$meta_key = '';
	if ( 'upvote' == $type ) {
		$meta_key = '_article_upvotes';
	} elseif ( 'downvote' == $type ) {
		$meta_key = '_article_downvotes';
	}

	$count = get_post_meta( $post_id, $meta_key, true );
	if ( $count )
		$count = $count + 1;
	else
		$count = 1;

	if ( update_post_meta( $post_id, $meta_key, $count ) ) {
		if ( is_user_logged_in() ) {
			halt_add_user_vote( $user_id, $post_id );
		}
		return true;
	}

	return false;
}

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
