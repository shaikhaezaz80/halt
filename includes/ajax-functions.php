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

		// Return, if post ID is not a number
		if ( ! is_numeric( $_POST['post_id'] ) ) return;

		if ( halt_add_article_vote( $_POST['user_id'], $_POST['post_id'], $_POST['vote_type'] ) ) {
			$response = array( 'code' => '1' );
		} else {
			$response = array( 'code' => '2' );
		}

		echo json_encode( $response );
	}

	die();
}
add_action( 'wp_ajax_halt_article_vote', 'halt_article_vote' );
add_action( 'wp_ajax_nopriv_halt_article_vote', 'halt_article_vote' );
