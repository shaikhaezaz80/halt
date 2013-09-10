<?php
/**
 * Weclome Page Class
 *
 * @package     CHC
 * @subpackage  Admin/Welcome
 * @copyright   Copyright (c) 2013, Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * CHC_Welcome Class
 *
 * A general class for About and Credits page.
 *
 * @since 1.4
 */
class CHC_Welcome {

	/**
	 * @var string The capability users should have to view the page
	 */
	public $minimum_capability = 'manage_options';

	/**
	 * Get things started
	 *
	 * @access  public
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus') );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'welcome'    ) );
	}

	/**
	 * Register the Dashboard Pages which are later hidden but these pages
	 * are used to render the Welcome and Credits pages.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function admin_menus() {
		// About Page
		add_dashboard_page(
			__( 'Welcome to Customer Help Center', 'chc' ),
			__( 'Welcome to Customer Help Center', 'chc' ),
			$this->minimum_capability,
			'chc-about',
			array( $this, 'about_screen' )
		);

		// Credits Page
		add_dashboard_page(
			__( 'Welcome to Customer Help Center', 'chc' ),
			__( 'Welcome to Customer Help Center', 'chc' ),
			$this->minimum_capability,
			'chc-credits',
			array( $this, 'credits_screen' )
		);
	}

	/**
	 * Hide Individual Dashboard Pages
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function admin_head() {
		remove_submenu_page( 'index.php', 'chc-about' );
		remove_submenu_page( 'index.php', 'chc-credits' );

		// Badge for welcome page
		$badge_url = CHC_PLUGIN_URL . 'assets/images/chc-badge.png';
		?>
		<style type="text/css" media="screen">
		/*<![CDATA[*/
		.chc-badge {
			padding-top: 150px;
			height: 52px;
			width: 185px;
			color: #666;
			font-weight: bold;
			font-size: 14px;
			text-align: center;
			text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
			margin: 0 -5px;
			background: url('<?php echo $badge_url; ?>') no-repeat;
		}

		.about-wrap .chc-badge {
			position: absolute;
			top: 0;
			right: 0;
		}

		.chc-welcome-screenshots {
			float: right;
			margin-left: 10px!important;
		}
		/*]]>*/
		</style>
		<?php
	}

	/**
	 * Render About Screen
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function about_screen() {
		list( $display_version ) = explode( '-', CHC_VERSION );
		?>

		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Customer Help Center %s', 'chc' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for using Customer Help Center %s it\'s ready to help your customers in a better way!', 'chc' ), $display_version ); ?></div>
			<div class="chc-badge"><?php printf( __( 'Version %s', 'chc' ), $display_version ); ?></div>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab nav-tab-active" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'chc-about' ), 'index.php' ) ) ); ?>">
					<?php _e( "What's New", 'chc' ); ?>
				</a><a class="nav-tab" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'chc-credits' ), 'index.php' ) ) ); ?>">
					<?php _e( 'Credits', 'chc' ); ?>
				</a>
			</h2>

			<div class="changelog">
				<h3><?php _e( 'Easy Peasy', 'chc' );?></h3>

				<div class="feature-section">
					<h4><?php _e( 'Prettier, More Versatile Styles', 'chc' );?></h4>
					<p><?php _e( 'We have completely rewritten the checkout CSS to make it more attractive, more flexible, and more compatible with a wider variety of themes.', 'chc' );?></p>

					<h4><?php _e( 'Better Checkout Layout', 'chc' );?></h4>
					<p><?php _e( 'The position of each field on the checkout has been carefully reconsidered to ensure it is in the proper location so as to best create high conversion rates.', 'chc' );?></p>
				</div>
			</div>

			<div class="return-to-dashboard">
				<a href="#">Go to Settings</a>
			</div>

		</div>

		<?php
	}

	/**
	 * Render Credits Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function credits_screen() {
		list( $display_version ) = explode( '-', CHC_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Customer Help Center %s', 'chc' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for using Customer Help Center %s it\'s ready to help your customers in a better way!', 'chc' ), $display_version ); ?></div>
			<div class="chc-badge"><?php printf( __( 'Version %s', 'chc' ), $display_version ); ?></div>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'chc-about' ), 'index.php' ) ) ); ?>">
					<?php _e( "What's New", 'chc' ); ?>
				</a><a class="nav-tab nav-tab-active" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'chc-credits' ), 'index.php' ) ) ); ?>">
					<?php _e( 'Credits', 'chc' ); ?>
				</a>
			</h2>

			<p class="about-description"><?php _e( 'Customer Help Center is created by a worldwide team of developers who aim to provide the #1 eCommerce platform for selling digital goods through WordPress.', 'chc' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Sends user to the Welcome page on first activation of CHC as well as each
	 * time CHC is upgraded to a new version
	 *
	 * @access public
	 * @since 1.4
	 * @global $chc_options Array of all the CHC Options
	 * @return void
	 */
	public function welcome() {
		global $chc_options;

		// Bail if no activation redirect
		if ( ! get_transient( '_chc_activation_redirect' ) )
			return;

		// Delete the redirect transient
		delete_transient( '_chc_activation_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
			return;

		wp_safe_redirect( admin_url( 'index.php?page=chc-about' ) ); exit;
	}
}
new CHC_Welcome();
