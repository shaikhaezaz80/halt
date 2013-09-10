<?php
/**
 * WC_Shortcodes class.
 *
 * @class 		CHC_Shortcodes
 * @version		2.0.0
 * @package		CHC/Classes
 * @category	Class
 * @author 		Ram Ratan Maurya
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class CHC_Shortcodes {
	public function __construct() {
		add_shortcode( 'chc_knowledgebase', array( $this, 'knowledgebase_single' ) );
	}

	public function knowledgebase_single( $atts ) {
		global $chc;
		return $chc->shortcode_wrapper( array( 'CHC_Shortcode_Knowledgebase_Single', 'output' ), $atts );
	}

}
