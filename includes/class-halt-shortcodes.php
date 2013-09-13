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
	}

	public function article_single( $atts ) {
		global $halt;
		return $halt->shortcode_wrapper( array( 'Halt_Shortcode_Article_Single', 'output' ), $atts );
	}

}
