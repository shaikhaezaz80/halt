<?php
/**
 * Halt_Shortcodes class.
 *
 * @class 		Halt_Shortcodes
 * @version		2.0.0
 * @package		Halt/Classes
 * @category	Class
 * @author 		Ram Ratan Maurya
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Halt_Shortcodes {
	public function __construct() {
		add_shortcode( 'halt_article', array( $this, 'article_single' ) );
		add_shortcode( 'halt_article_link', array( $this, 'article_link' ) );
	}

	/**
	 * Article Single Shortcode
	 *
	 * @access public
	 * @param mixed $atts
	 * @return string
	 */
	public function article_single( $atts ) {
		global $halt;
		return $halt->shortcode_wrapper( array( 'Halt_Shortcode_Article_Single', 'output' ), $atts );
	}

	/**
	 * Article Link Shortcode
	 *
	 * @access public
	 * @param mixed $atts
	 * @return string
	 */
	public function article_link( $atts ) {
		global $halt;
		return $halt->shortcode_wrapper( array( 'Halt_Shortcode_Article_Link', 'output' ), $atts, false );
	}

}
