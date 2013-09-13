<?php
/**
 * Halt Core Functions
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
 * Get template part (for templates like the article-loop).
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function halt_get_template_part( $slug, $name = '' ) {

	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/halt/slug-name.php
	if ( $name )
		$template = locate_template( array ( "{$slug}-{$name}.php", "{TEMPLATE_URL}{$slug}-{$name}.php" ) );

	// Get default slug-name.php
	if ( !$template && $name && file_exists( HALT_PLUGIN_DIR . "/templates/{$slug}-{$name}.php" ) )
		$template = HALT_PLUGIN_DIR . "/templates/{$slug}-{$name}.php";

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/halt/slug.php
	if ( !$template )
		$template = locate_template( array ( "{$slug}.php", "{TEMPLATE_URL}{$slug}.php" ) );

	if ( $template )
		load_template( $template, false );
}

/**
 * Get other templates (e.g. article attributes) passing attributes and including the file.
 *
 * @access public
 * @param mixed $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function halt_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( $args && is_array($args) )
		extract( $args );

	$located = halt_locate_template( $template_name, $template_path, $default_path );

	do_action( 'halt_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'halt_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 *
 * @access public
 * @param mixed $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function halt_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	if ( ! $template_path ) $template_path = TEMPLATE_URL;
	if ( ! $default_path ) $default_path = HALT_PLUGIN_DIR . '/templates/';

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template )
		$template = $default_path . $template_name;

	// Return what we found
	return apply_filters('halt_locate_template', $template, $template_name, $template_path);
}
