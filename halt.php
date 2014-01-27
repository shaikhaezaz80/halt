<?php
/**
 * Plugin Name: Halt
 * Plugin URI: http://halt.io
 * Description: Changing the way you assist your customers
 * Author: Ram Ratan Maurya
 * Author URI: http://mauryaratan.me
 * Version: 0.1
 * Text Domain: halt
 * Domain Path: languages
 *
 * Halt is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Halt is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Halt. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Halt
 * @category Core
 * @author Ram Ratan Maurya
 * @version 0.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Halt' ) ) :

/**
 * Main Halt Class
 *
 * @since 0.1
 */

final class Halt {

	/**
	 * @var Halt The one true Halt
	 * @since 0.1
	 */
	private static $instance;

	/**
	 * Halt User Roles and Capabilities Object
	 *
	 * @var object
	 */
	public $roles;

	public function __construct() {

		// Auto-load classes on demand
		if ( function_exists( "__autoload" ) ) {
			spl_autoload_register( "__autoload" );
    	}
		spl_autoload_register( array( $this, 'autoload' ) );

		// Hooks
		add_action( 'init', array( $this, 'init' ), 0 );

		// Loaded action
		do_action( 'halt_loaded' );
	}

	/**
	 * Main Halt Instance
	 *
	 * Insures that only one instance of Halt exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since Halt 0.1
	 * @static var array $instance
	 * @uses Halt::setup_globals() Setup the globals needed
	 * @uses Halt::includes() Include the required files
	 * @uses Halt::setup_actions() Setup the hooks and actions
	 * @see HALT()
	 * @return The one true Halt
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Halt ) ) {
			self::$instance = new Halt;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->load_textdomain();
			self::$instance->roles = new Halt_Roles();
		}
		return self::$instance;
	}

	/**
	 * Throw error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 0.1
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'halt' ), '0.1' );
	}

	/**
	 * Disable unserializing of the class.
	 *
	 * @since 0.1
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'halt' ), '0.1' );
	}

	/**
	 * Init Halt when WordPress Initialises.
	 *
	 * @access public
	 * @return void
	 */
	public function init() {

		if ( ! is_admin() || defined('DOING_AJAX') ) {
			$this->shortcodes = new Halt_Shortcodes();	// Shortcodes class, controls all frontend shortcodes

			add_filter( 'template_include', array( $this, 'template_loader' ) );
			add_filter( 'body_class', array( $this, 'body_class' ) );

			// Init action
			do_action( 'halt_init' );
		}
	}

	/**
	 * Auto-load Halt classes on demand to reduce memory consumption.
	 *
	 * @access public
	 * @param mixed $class
	 * @return void
	 */
	public function autoload( $class ) {
		$class = strtolower( $class );

		if( strpos( $class, 'halt_' ) === 0 ) {

			$path = HALT_PLUGIN_DIR . 'includes/classes/';
			$file = 'class-' . str_replace( '_', '-', $class ) . '.php';

			if ( is_readable( $path . $file ) ) {
				include_once( $path . $file );
				return;
			}
		}

		if( strpos( $class, 'halt_shortcode_' ) === 0 ) {

			$path = HALT_PLUGIN_DIR . 'includes/shortcodes/';
			$file = 'class-' . str_replace( '_', '-', $class ) . '.php';

			if ( is_readable( $path . $file ) ) {
				include_once( $path . $file );
				return;
			}
		}
	}

	/**
	 * Setup plugin constants.
	 *
	 * @access private
	 * @since 0.1
	 * @return void
	 */
	private function setup_constants() {
		// Plugin version
		if ( ! defined( 'HALT_VERSION' ) )
			define( 'HALT_VERSION', '0.1' );

		// Plugin Folder Path
		if ( ! defined( 'HALT_PLUGIN_DIR' ) )
			define( 'HALT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin Folder URL
		if ( ! defined( 'HALT_PLUGIN_URL' ) )
			define( 'HALT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		// Plugin Root File
		if ( ! defined( 'HALT_PLUGIN_FILE' ) )
			define( 'HALT_PLUGIN_FILE', __FILE__ );

		// Halt Templates URL
		if ( ! defined( 'TEMPLATE_URL' ) )
			define( 'TEMPLATE_URL', apply_filters( 'halt_template_url', 'halt/' ) );
	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 0.1
	 * @return void
	 */
	private function includes() {
		global $halt_options;

		require_once HALT_PLUGIN_DIR . 'includes/admin/settings/register-settings.php';
		$halt_options = halt_get_settings();

		// Both Admin and Frontend includes
		require_once HALT_PLUGIN_DIR . 'includes/actions.php';
		require_once HALT_PLUGIN_DIR . 'includes/install.php';
		require_once HALT_PLUGIN_DIR . 'includes/mime-types.php';
		require_once HALT_PLUGIN_DIR . 'includes/scripts.php';
		require_once HALT_PLUGIN_DIR . 'includes/custom-post-types.php';
		require_once HALT_PLUGIN_DIR . 'includes/template-functions.php';
		require_once HALT_PLUGIN_DIR . 'includes/article-functions.php';
		require_once HALT_PLUGIN_DIR . 'includes/ajax-functions.php';
		require_once HALT_PLUGIN_DIR . 'includes/misc-functions.php';

		require_once HALT_PLUGIN_DIR . 'includes/class-halt-roles.php';
		require_once HALT_PLUGIN_DIR . 'includes/class-halt-shortcodes.php';

		if( is_admin() ) {
			// Admin includes
			require_once HALT_PLUGIN_DIR . 'includes/admin/welcome.php';
			require_once HALT_PLUGIN_DIR . 'includes/admin/admin-pages.php';
			require_once HALT_PLUGIN_DIR . 'includes/admin/admin-notices.php';
			require_once HALT_PLUGIN_DIR . 'includes/admin/dashboard-widgets.php';
			require_once HALT_PLUGIN_DIR . 'includes/admin/settings/settings.php';
			require_once HALT_PLUGIN_DIR . 'includes/admin/settings/contextual-help.php';
			require_once HALT_PLUGIN_DIR . 'includes/admin/tools.php';
		} else {
			// Front-end includes

		}

	}

	/**
	 * Loads the plugin language files.
	 *
	 * @access public
	 * @since 0.1
	 * @return void
	 */
	public function load_textdomain() {
		// Set filter for plugin's languages directory
		$halt_lang_dir = dirname( plugin_basename( HALT_PLUGIN_FILE ) ) . '/languages/';
		$halt_lang_dir = apply_filters( 'halt_languages_directory', $halt_lang_dir );

		// Traditional WordPress plugin locale filter
		$locale        = apply_filters( 'plugin_locale',  get_locale(), 'halt' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'halt', $locale );

		// Setup paths to current locale file
		$mofile_local  = $halt_lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/halt/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/halt folder
			load_textdomain( 'halt', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/halt/languages/ folder
			load_textdomain( 'halt', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'halt', false, $halt_lang_dir );
		}
	}

	/**
	 * Shortcode Wrapper.
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
			'class' => 'halt',
			'before' => null,
			'after' => null
		)
	){
		ob_start();

		$before = $after = '';

		if( is_array( $wrapper ) ) {
			$before 	= empty( $wrapper['before'] ) ? '<div class="' . $wrapper['class'] . '">' : $wrapper['before'];
			$after 		= empty( $wrapper['after'] ) ? '</div>' : $wrapper['after'];
		}

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
	 * Templates are in the 'templates' folder. halt looks for theme
	 * overrides in /theme/halt/ by default
	 *
	 * For beginners, it also looks for a halt.php template first. If the user adds
	 * this to the theme (containing a halt() inside) this will be used for all
	 * halt templates.
	 *
	 * @access public
	 * @param mixed $template
	 * @return string
	 */
	public function template_loader( $template ) {
		$find = array( 'halt.php' );
		$file = '';

		if ( is_single() && get_post_type() == 'article' ) {

			$file 	= 'single-article.php';
			$find[] = $file;
			$find[] = TEMPLATE_URL . $file;

		} elseif ( is_tax( 'article_cat' ) || is_tax( 'article_tag' ) ) {

			$term = get_queried_object();
			$file 		= 'taxonomy-' . $term->taxonomy . '.php';
			$find[] 	= 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] 	= TEMPLATE_URL . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] 	= $file;
			$find[] 	= TEMPLATE_URL . $file;

		} elseif ( is_post_type_archive( 'article' ) ) {

			$file 	= 'archive-article.php';
			$find[] = $file;
			$find[] = TEMPLATE_URL . $file;

		}

		if( $file ) {
			$template = locate_template( $find );
			if ( ! $template ) $template = HALT_PLUGIN_DIR . 'templates/' . $file;
		}

		return $template;
	}

	/**
	 * Add Halt body class.
	 *
	 * @param  array $classes
	 * @return array
	 */
	public function body_class( $classes ) {

		$classes[] = 'halt';

		if( 'article' == get_post_type() && is_single() ) {
			$classes[] = 'halt-article';
		}

		return $classes;
	}
}

endif; // End if class_exists check


/**
 * The main function responsible for returning the one true Halt
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @example <?php $halt = HALT(); ?>
 * @since 0.1
 * @return object The one true Halt Instance
 */
function HALT() {
	return Halt::instance();
}

// Get HALT Running
HALT();

// Debug
define('SCRIPT_DEBUG', true);
