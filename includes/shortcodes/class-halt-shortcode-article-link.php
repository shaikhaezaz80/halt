<?php
/**
 * Article Shortcode
 *
 *
 * @author 		Ram Ratan Maurya
 * @category 	Shortcodes
 * @package 	Halt/Shortcodes
 */
class Halt_Shortcode_Article_Link {

	public static function get( $atts ) {
		global $halt;
		return $halt->shortcode_wrapper( array( __CLASS__, 'id' ), $atts );
	}

	public static function output( $atts ) {

		extract( shortcode_atts( array(
			'id' => null,
			'title' => null
		), $atts ) );

		if( is_null($id) ) $id = $atts[0];
		if( is_null($title) && !empty($title) ) $title = $atts[1];

		$text = ( isset($title) && !is_null($title) ) ? $title : '#'.$id;

		echo '<a href="' . get_permalink( $id ) . '">'. $text .'</a>';
	}
}
