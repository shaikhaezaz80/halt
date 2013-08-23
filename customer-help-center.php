<?php
/**
 * Plugin Name: Customer Help Center
 * Plugin URI: http://codestag.com/plugins/help-center
 * Description: Customer Self Service Help Center
 * Author: Ram Ratan Maurya
 * Author URI: http://mauryaratan.me
 * Version: 0.1
 * Text Domain: chc
 * Domain Path: languages
 *
 * Customer Help Center is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Customer Help Center is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Customer Help Center. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package CHC
 * @category Core
 * @author Ram Ratan Maurya
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Customer_Help_Center' ) ) :

/**
 * Main Customer_Help_Center Class
 *
 * @since 1.0
 */

final class Customer_Help_Center {

	/**
	 * @var Customer_Help_Center The one true Customer_Help_Center
	 * @since 1.0
	 */
	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Customer_Help_Center ) ) {
			self::$instance = new Customer_Help_Center;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->load_textdomain();
		}
		return self::$instance;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'chc' ), '1.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'chc' ), '1.0' );
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.4
	 * @return void
	 */
	private function setup_constants() {
		// Plugin version
		if ( ! defined( 'CHC_VERSION' ) )
			define( 'CHC_VERSION', '0.1' );

		// Plugin Folder Path
		if ( ! defined( 'CHC_PLUGIN_DIR' ) )
			define( 'CHC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin Folder URL
		if ( ! defined( 'CHC_PLUGIN_URL' ) )
			define( 'CHC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		// Plugin Root File
		if ( ! defined( 'CHC_PLUGIN_FILE' ) )
			define( 'CHC_PLUGIN_FILE', __FILE__ );
	}

	/**
	 * Include required files
	 *
	 * @access private
	 * @since 1.4
	 * @return void
	 */
	private function includes() {
		global $chc_options;

		if( is_admin() ) {
			// require_once CHC_PLUGIN_DIR . 'includes/admin/welcome.php';
		}

	}

	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function load_textdomain() {
		// Set filter for plugin's languages directory
		$chc_lang_dir = dirname( plugin_basename( CHC_PLUGIN_FILE ) ) . '/languages/';
		$chc_lang_dir = apply_filters( 'chc_languages_directory', $chc_lang_dir );

		// Traditional WordPress plugin locale filter
		$locale        = apply_filters( 'plugin_locale',  get_locale(), 'chc' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'chc', $locale );

		// Setup paths to current locale file
		$mofile_local  = $chc_lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/chc/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/chc folder
			load_textdomain( 'chc', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/easy-digital-downloads/languages/ folder
			load_textdomain( 'chc', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'chc', false, $chc_lang_dir );
		}
	}
}

endif; // End if class_exists check


/**
 * The main function responsible for returning the one true Customer_Help_Center
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $chc = CHC(); ?>
 *
 * @since 1.4
 * @return object The one true Customer_Help_Center Instance
 */
function CHC(){
	return Customer_Help_Center::instance();
}

// Get CHC Running
CHC();
