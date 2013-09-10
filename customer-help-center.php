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

	public function __construct() {
		// Auto-load classes on demand
		if ( function_exists( "__autoload" ) ) {
			spl_autoload_register( "__autoload" );
    	}
		spl_autoload_register( array( $this, 'autoload' ) );
		
		add_action( 'init', array( $this, 'init' ), 0 );
	}

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
	 * Init CHC when WordPress Initialises.
	 *
	 * @access public
	 * @return void
	 */
	public function init() {

		if ( ! is_admin() || defined('DOING_AJAX') ) {
			$this->shortcodes = new CHC_Shortcodes();			// Shortcodes class, controls all frontend shortcodes

			add_filter( 'template_include', array( $this, 'template_loader' ) );
			add_filter( 'body_class', array( $this, 'body_class' ) );

			// Init action
			do_action( 'chc_init' );
		}
	}

	/**
	 * Auto-load CHC classes on demand to reduce memory consumption.
	 *
	 * @access public
	 * @param mixed $class
	 * @return void
	 */
	public function autoload( $class ) {
		$class = strtolower( $class );

		if( strpos( $class, 'chc_shortcode_' ) === 0 ) {
			$path = CHC_PLUGIN_DIR . 'includes/shortcodes/';
			$file = 'class-' . str_replace( '_', '-', $class ) . '.php';
			
			if ( is_readable( $path . $file ) ) {
				include_once( $path . $file );
				return;
			}
		}
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

		// CHC TEMPLATES URL
		if ( ! defined( 'TEMPLATE_URL' ) )
			define( 'TEMPLATE_URL', apply_filters( 'chc_template_url', 'chc/' ) );
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

		require_once CHC_PLUGIN_DIR . 'includes/admin/settings/register-settings.php';
		$chc_options = chc_get_settings();

		// Both Admin and Frontend includes
		require_once CHC_PLUGIN_DIR . 'includes/mime-types.php';
		require_once CHC_PLUGIN_DIR . 'includes/scripts.php';
		require_once CHC_PLUGIN_DIR . 'includes/custom-post-types.php';
		require_once CHC_PLUGIN_DIR . 'includes/template-functions.php';
		require_once CHC_PLUGIN_DIR . 'includes/ajax-functions.php';

		if( is_admin() ) {
			// Admin includes
			require_once CHC_PLUGIN_DIR . 'includes/admin/welcome.php';
			require_once CHC_PLUGIN_DIR . 'includes/admin/admin-pages.php';
			require_once CHC_PLUGIN_DIR . 'includes/admin/dashboard-widgets.php';
			require_once CHC_PLUGIN_DIR . 'includes/admin/settings/settings.php';
			require_once CHC_PLUGIN_DIR . 'includes/admin/settings/contextual-help.php';
		} else {
			// Front-end includes
			require_once CHC_PLUGIN_DIR . 'includes/class-chc-shortcodes.php';
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
			// Look in local /wp-content/plugins/customer-help-center/languages/ folder
			load_textdomain( 'chc', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'chc', false, $chc_lang_dir );
		}
	}

	/**
	 * Shortcode Wrapper
	 *
	 * @access public
	 * @param mixed $function
	 * @param array $atts (default: array())
	 * @return string
	 */
	public function shortcode_wrapper(
		$function,
		$atts = array(),
		$wrapper = array(
			'class' => 'chc',
			'before' => null,
			'after' => null
		)
	){
		ob_start();

		$before 	= empty( $wrapper['before'] ) ? '<div class="' . $wrapper['class'] . '">' : $wrapper['before'];
		$after 		= empty( $wrapper['after'] ) ? '</div>' : $wrapper['after'];

		echo $before;
		call_user_func( $function, $atts );
		echo $after;

		return ob_get_clean();
	}

	/**
	 * Load a template.
	 *
	 * Handles template usage so that we can use our own templates instead of the themes.
	 *
	 * Templates are in the 'templates' folder. chc looks for theme
	 * overrides in /theme/chc/ by default
	 *
	 * For beginners, it also looks for a chc.php template first. If the user adds
	 * this to the theme (containing a chc() inside) this will be used for all
	 * chc templates.
	 *
	 * @access public
	 * @param mixed $template
	 * @return string
	 */
	public function template_loader( $template ) {
		$find = array( 'customer-helper-center.php' );
		$file = '';

		if ( is_single() && get_post_type() == 'knowledgebase' ) {


			$file 	= 'single-knowledgebase.php';
			$find[] = $file;
			$find[] = TEMPLATE_URL . $file;

		} elseif ( is_tax( 'knowledgebase_category' ) || is_tax( 'knowledgebase_tags' ) ) {

			$term = get_queried_object();
			$file 		= 'taxonomy-' . $term->taxonomy . '.php';
			$find[] 	= 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] 	= TEMPLATE_URL . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] 	= $file;
			$find[] 	= TEMPLATE_URL . $file;

		} elseif ( is_post_type_archive( 'knowledgebase' ) ) {

			$file 	= 'archive-knowledgebase.php';
			$find[] = $file;
			$find[] = TEMPLATE_URL . $file;

		}

		if( $file ) {
			$template = locate_template( $find );
			if ( ! $template ) $template = CHC_PLUGIN_DIR . 'templates/' . $file;
		}

		return $template;
	}

	public function body_class( $classes ) {
		
		$classes[] = 'chc';

		return $classes;
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

global $chc;
$chc = CHC();

// Get CHC Running
CHC();
