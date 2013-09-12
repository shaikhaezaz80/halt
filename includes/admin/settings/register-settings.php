<?php
/**
 * Register Settings
 *
 * @package     Halt
 * @subpackage  Admin/Settings
 * @author 		Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Registers all of the required Halt settings and provides hooks for extensions
 * to add their own settings to either the General or Misc Settings Pages
 *
 * @since 1.0
 * @return void
*/
function halt_register_settings() {
	$pages = get_pages();
	$pages_option = array( 0 => '' ); // For Blank Option

	if ( $pages ) {
		foreach ( $pages as $page ) {
			$pages_options[ $page->ID ] = $page->post_title;
		}
	}

	/**
	 * 'Whitelisted' Halt settings, filters are provided for each settings
	 * section to allow extensions and other plugins to add their own settings
	 */
	$halt_settings = array(
		'general' => apply_filters( 'halt_settings_general',
			array(
			)
		),
		'knowledgebase' => apply_filters( 'halt_settings_knowledgebase',
			array(
				'knowledgebase_slug' => array(
					'id' => 'knowledgebase_slug',
					'name' => __( 'Knowledgebase Slug', 'halt' ),
					'desc' => __( 'Enter the slug for knowledebase e.g. knowledgebase or article', 'halt' ),
					'type' => 'text',
					'size' => 'regular',
					'std' => 'knowledgebase'
				),
			)
		),
	);

	if ( false == get_option( 'halt_settings_general' ) ) {
		add_option( 'halt_settings_general' );
	}

	if ( false == get_option( 'halt_settings_knowledgebase' ) ) {
		add_option( 'halt_settings_knowledgebase' );
	}

	add_settings_section(
		'halt_settings_general',
		__( 'General Settings', 'halt' ),
		'__return_false',
		'halt_settings_general'
	);

	foreach ( $halt_settings['general'] as $option ) {
		add_settings_field(
			'halt_settings_general[' . $option['id'] . ']',
			$option['name'],
			function_exists( 'halt_' . $option['type'] . '_callback' ) ? 'halt_' . $option['type'] . '_callback' : 'halt_missing_callback',
			'halt_settings_general',
			'halt_settings_general',
			array(
				'id' => $option['id'],
				'desc' => $option['desc'],
				'name' => $option['name'],
				'section' => 'general',
				'size' => isset( $option['size'] ) ? $option['size'] : null,
				'options' => isset( $option['options'] ) ? $option['options'] : '',
				'std' => isset( $option['std'] ) ? $option['std'] : ''
			)
		);
	}

	add_settings_section(
		'halt_settings_knowledgebase',
		__( 'Knowledgebase Settings', 'halt' ),
		'__return_false',
		'halt_settings_knowledgebase'
	);

	foreach ( $halt_settings['knowledgebase'] as $option ) {
		add_settings_field(
			'halt_settings_knowledgebase[' . $option['id'] . ']',
			$option['name'],
			function_exists( 'halt_' . $option['type'] . '_callback' ) ? 'halt_' . $option['type'] . '_callback' : 'halt_missing_callback',
			'halt_settings_knowledgebase',
			'halt_settings_knowledgebase',
			array(
				'id' => $option['id'],
				'desc' => $option['desc'],
				'name' => $option['name'],
				'section' => 'knowledgebase',
				'size' => isset( $option['size'] ) ? $option['size'] : null,
				'options' => isset( $option['options'] ) ? $option['options'] : '',
				'std' => isset( $option['std'] ) ? $option['std'] : ''
			)
		);
	}

	register_setting( 'halt_settings_general',    'halt_settings_general',    'halt_settings_sanitize' );
	register_setting( 'halt_settings_knowledgebase',    'halt_settings_knowledgebase',    'halt_settings_sanitize' );
}
add_action('admin_init', 'halt_register_settings');


/**
 * Checkbox Callback
 *
 * Renders checkboxes.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $halt_options Array of all the Halt Options
 * @return void
 */
function halt_checkbox_callback( $args ) {
	global $halt_options;

	$checked = isset($halt_options[$args['id']]) ? checked(1, $halt_options[$args['id']], false) : '';
	$html = '<input type="checkbox" id="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" name="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" value="1" ' . $checked . '/>';
	$html .= '<label for="halt_settings_' . $args['section'] . '[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Multicheck Callback
 *
 * Renders multiple checkboxes.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $halt_options Array of all the Halt Options
 * @return void
 */
function halt_multicheck_callback( $args ) {
	global $halt_options;

	foreach( $args['options'] as $key => $option ):
		if( isset( $halt_options[$args['id']][$key] ) ) { $enabled = $option; } else { $enabled = NULL; }
		echo '<input name="halt_settings_' . $args['section'] . '[' . $args['id'] . '][' . $key . ']"" id="halt_settings_' . $args['section'] . '[' . $args['id'] . '][' . $key . ']" type="checkbox" value="' . $option . '" ' . checked($option, $enabled, false) . '/>&nbsp;';
		echo '<label for="halt_settings_' . $args['section'] . '[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';
	endforeach;
	echo '<p class="description">' . $args['desc'] . '</p>';
}

/**
 * Radio Callback
 *
 * Renders radio boxes.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $halt_options Array of all the Halt Options
 * @return void
 */
function halt_radio_callback( $args ) {
	global $halt_options;

	foreach ( $args['options'] as $key => $option ) :
		$checked = false;

		if ( isset( $halt_options[ $args['id'] ] ) && $halt_options[ $args['id'] ] == $key )
			$checked = true;
		elseif( isset( $args['std'] ) && $args['std'] == $key && ! isset( $halt_options[ $args['id'] ] ) )
			$checked = true;

		echo '<input name="halt_settings_' . $args['section'] . '[' . $args['id'] . ']"" id="halt_settings_' . $args['section'] . '[' . $args['id'] . '][' . $key . ']" type="radio" value="' . $key . '" ' . checked(true, $checked, false) . '/>&nbsp;';
		echo '<label for="halt_settings_' . $args['section'] . '[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';
	endforeach;

	echo '<p class="description">' . $args['desc'] . '</p>';
}

/**
 * Text Callback
 *
 * Renders text fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $halt_options Array of all the Halt Options
 * @return void
 */
function halt_text_callback( $args ) {
	global $halt_options;

	if ( isset( $halt_options[ $args['id'] ] ) )
		$value = $halt_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$size = isset( $args['size'] ) && !is_null($args['size']) ? $args['size'] : 'regular';
	$html = '<input type="text" class="' . $args['size'] . '-text" id="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" name="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" value="' . esc_attr( $value ) . '"/>';
	$html .= '<label for="halt_settings_' . $args['section'] . '[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Textarea Callback
 *
 * Renders textarea fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $halt_options Array of all the Halt Options
 * @return void
 */
function halt_textarea_callback( $args ) {
	global $halt_options;

	if ( isset( $halt_options[ $args['id'] ] ) )
		$value = $halt_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$size = isset( $args['size'] ) && !is_null($args['size']) ? $args['size'] : 'regular';
	$html = '<textarea class="large-text" cols="50" rows="5" id="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" name="halt_settings_' . $args['section'] . '[' . $args['id'] . ']">' . esc_textarea( $value ) . '</textarea>';
	$html .= '<label for="halt_settings_' . $args['section'] . '[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Password Callback
 *
 * Renders password fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $halt_options Array of all the Halt Options
 * @return void
 */
function halt_password_callback( $args ) {
	global $halt_options;

	if ( isset( $halt_options[ $args['id'] ] ) )
		$value = $halt_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$size = isset( $args['size'] ) && !is_null($args['size']) ? $args['size'] : 'regular';
	$html = '<input type="password" class="' . $args['size'] . '-text" id="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" name="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" value="' . esc_attr( $value ) . '"/>';
	$html .= '<label for="halt_settings_' . $args['section'] . '[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Missing Callback
 *
 * If a function is missing for settings callbacks alert the user.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @return void
 */
function halt_missing_callback($args) {
	printf( __( 'The callback function used for the <strong>%s</strong> setting is missing.', 'halt' ), $args['id'] );
}

/**
 * Select Callback
 *
 * Renders select fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $halt_options Array of all the Halt Options
 * @return void
 */
function halt_select_callback($args) {
	global $halt_options;

	if ( isset( $halt_options[ $args['id'] ] ) )
		$value = $halt_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$html = '<select id="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" name="halt_settings_' . $args['section'] . '[' . $args['id'] . ']"/>';

	foreach ( $args['options'] as $option => $name ) :
		$selected = selected( $option, $value, false );
		$html .= '<option value="' . $option . '" ' . $selected . '>' . $name . '</option>';
	endforeach;

	$html .= '</select>';
	$html .= '<label for="halt_settings_' . $args['section'] . '[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Rich Editor Callback
 *
 * Renders rich editor fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $halt_options Array of all the Halt Options
 * @global $wp_version WordPress Version
 */
function halt_rich_editor_callback( $args ) {
	global $halt_options, $wp_version;

	if ( isset( $halt_options[ $args['id'] ] ) )
		$value = $halt_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	if ( $wp_version >= 3.3 && function_exists( 'wp_editor' ) ) {
		$html = wp_editor( $value, 'halt_settings_' . $args['section'] . '[' . $args['id'] . ']', array( 'textarea_name' => 'halt_settings_' . $args['section'] . '[' . $args['id'] . ']' ) );
	} else {
		$html = '<textarea class="large-text" rows="10" id="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" name="halt_settings_' . $args['section'] . '[' . $args['id'] . ']">' . esc_textarea( $value ) . '</textarea>';
	}

	$html .= '<br/><label for="halt_settings_' . $args['section'] . '[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Upload Callback
 *
 * Renders upload fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $halt_options Array of all the Halt Options
 * @return void
 */
function halt_upload_callback($args) {
	global $halt_options;

	if ( isset( $halt_options[ $args['id'] ] ) )
		$value = $halt_options[$args['id']];
	else
		$value = isset($args['std']) ? $args['std'] : '';

	$size = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

	$html = '<input type="text" class="' . $args['size'] . '-text halt_upload_field" id="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" name="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" value="' . esc_attr( $value ) . '"/>';
	$html .= '<span>&nbsp;<input type="button" class="halt_settings_upload_button button-secondary" value="' . __( 'Upload File', 'halt' ) . '"/></span>';
	$html .= '<label for="halt_settings_' . $args['section'] . '[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}


/**
 * Color picker Callback
 *
 * Renders color picker fields.
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @global $halt_options Array of all the Halt Options
 * @return void
 */
function halt_color_callback( $args ) {
	global $halt_options;

	if ( isset( $halt_options[ $args['id'] ] ) )
		$value = $halt_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$default = isset( $args['std'] ) ? $args['std'] : '';

	$size = isset( $args['size'] ) && !is_null($args['size']) ? $args['size'] : 'regular';
	$html = '<input type="text" class="halt-color-picker" id="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" name="halt_settings_' . $args['section'] . '[' . $args['id'] . ']" value="' . esc_attr( $value ) . '" data-default-color="' . esc_attr( $default ) . '" />';
	$html .= '<label for="halt_settings_' . $args['section'] . '[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo $html;
}

/**
 * Hook Callback
 *
 * Adds a do_action() hook in place of the field
 *
 * @since 1.0
 * @param array $args Arguments passed by the setting
 * @return void
 */
function halt_hook_callback( $args ) {
	do_action( 'halt_' . $args['id'] );
}


/**
 * Settings Sanitization
 *
 * Adds a settings error (for the updated message)
 * At some point this will validate input
 *
 * @since 1.0
 * @param array $input The value inputted in the field
 * @return string $input Sanitizied value
 */
function halt_settings_sanitize( $input ) {
	add_settings_error( 'halt-notices', '', __( 'Settings Updated', 'halt' ), 'updated' );
	return $input;
}

/**
 * Get Settings
 *
 * Retrieves all plugin settings and returns them as a combined array.
 *
 * @since 1.0
 * @return array Merged array of all the Halt settings
 */
function halt_get_settings() {
	$general_settings = is_array( get_option( 'halt_settings_general' ) )    ? get_option( 'halt_settings_general' )  	: array();
	$knowledgebase_settings = is_array( get_option( 'halt_settings_knowledgebase' ) )   ? get_option( 'halt_settings_knowledgebase' ) 	: array();

	return array_merge( $general_settings, $knowledgebase_settings );
}
