<?php
/**
 * AJAX Functions
 *
 * Process the front-end AJAX actions.
 *
 * @package     Halt
 * @subpackage  Functions/AJAX
 * @author 		Ram Ratan Maurya
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) die();

/**
 * Knowledgebase/Article upvote and downvotes.
 *
 * @since 1.0
 * @return void
 */
function halt_article_vote() {
	if ( isset( $_POST['vote_type'] ) && check_ajax_referer( 'halt_ajax_nonce', 'nonce' ) ) {
		$vote_type = $_POST['vote_type'];
		$postid    = $_POST['postid'];

		if ( !is_numeric($postid) ) return;

		if ( ! isset( $_COOKIE['article_vote_' . $postid] ) ) {
			setcookie( 'article_vote_' . $postid , $postid, time() * 20, '/' );

			if ( $vote_type == "positive" ) {

				$upvotes = get_post_meta( $postid, '_article_upvotes', true );
				update_post_meta( $postid, '_article_upvotes', $upvotes + 1 );

				// Override to get new value
				$upvotes = get_post_meta( $postid, '_article_upvotes', true );
				echo $upvotes;

			} elseif ( $vote_type == "negative" ) {

				$downvotes = get_post_meta( $postid, '_article_downvotes', true );
				update_post_meta( $postid, '_article_downvotes', $downvotes + 1 );

				// Override to get new value
				$downvotes = get_post_meta( $postid, '_article_downvotes', true );
				echo $downvotes;

			}
		} else {
			return false;
		}
	}

	die();
}
add_action( 'wp_ajax_halt_article_vote', 'halt_article_vote' );
add_action( 'wp_ajax_nopriv_halt_article_vote', 'halt_article_vote' );
