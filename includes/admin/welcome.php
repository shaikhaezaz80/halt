<?php
/**
 * Weclome Page Class
 *
 * @package     Halt
 * @subpackage  Admin/Welcome
 * @author   	Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Halt_Welcome Class
 *
 * A general class for About and Credits page.
 *
 * @since 1.0
 */
class Halt_Welcome {

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
			__( 'Welcome to Halt', 'halt' ),
			__( 'Welcome to Halt', 'halt' ),
			$this->minimum_capability,
			'halt-about',
			array( $this, 'about_screen' )
		);

		// Credits Page
		add_dashboard_page(
			__( 'Welcome to Halt', 'halt' ),
			__( 'Welcome to Halt', 'halt' ),
			$this->minimum_capability,
			'halt-credits',
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
		remove_submenu_page( 'index.php', 'halt-about' );
		remove_submenu_page( 'index.php', 'halt-credits' );

		// Badge for welcome page
		$badge_url = HALT_PLUGIN_URL . 'assets/images/halt-badge.png';
		?>
		<style type="text/css" media="screen">
		/*<![CDATA[*/
		.halt-badge {
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

		.about-wrap .halt-badge {
			position: absolute;
			top: 0;
			right: 0;
		}

		.halt-welcome-screenshots {
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
		list( $display_version ) = explode( '-', HALT_VERSION );
		?>

		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Halt %s', 'halt' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for using Halt %s. Halt is ready to assist your customers in an easy and better way!', 'halt' ), $display_version ); ?></div>
			<div class="halt-badge"><?php printf( __( 'Version %s', 'halt' ), $display_version ); ?></div>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab nav-tab-active" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'halt-about' ), 'index.php' ) ) ); ?>">
					<?php _e( "What's New", 'halt' ); ?>
				</a><a class="nav-tab" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'halt-credits' ), 'index.php' ) ) ); ?>">
					<?php _e( 'Credits', 'halt' ); ?>
				</a>
			</h2>

			<div class="changelog">
				<h3><?php _e( 'Articles', 'halt' );?></h3>

				<div class="feature-section col three-col">
					<div>
						<h4><?php _e( 'Upvote / Downvote', 'halt' );?></h4>
						<p><?php _e( 'Let your visitor upvote / downvote your ariticles for better feedback so you can know how useful the article is.', 'halt' );?></p>
					</div>

					<div>
						<h4><?php _e( 'Revisions', 'halt' );?></h4>
						<p><?php _e( 'Easily go back into time using revisions to keep track of what is changed and when. Help you undo / redo your changes to an article.', 'halt' );?></p>
					</div>

					<div class="last-feature">
						<h4><?php _e( 'Report', 'halt' );?></h4>
						<p><?php _e( 'Let your visitors report an article if it is missing something or if it needs an edit.', 'halt' );?></p>
					</div>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Under the Hood', 'stag' ); ?></h3>

				<div class="feature-section col three-col">
					<div>
						<h4><?php _e( 'Retina Support', 'stag' ); ?></h4>
						<p><?php _e( 'Every image and icon used in Halt completely supports high resolution / retina displays.', 'stag' ) ?></p>
					</div>
				</div>
			</div>

			<div class="return-to-dashboard">
				<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'halt-settings' ), 'admin.php' ) ) ); ?>"><?php _e( 'Go to Halt Settings', 'halt' ); ?></a>
			</div>

		</div>

		<?php
	}

	/**
	 * Render Credits Screen
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function credits_screen() {
		list( $display_version ) = explode( '-', HALT_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Halt %s', 'halt' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for using Halt %s. Halt is ready to assist your customers in an easy and better way!', 'halt' ), $display_version ); ?></div>
			<div class="halt-badge"><?php printf( __( 'Version %s', 'halt' ), $display_version ); ?></div>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'halt-about' ), 'index.php' ) ) ); ?>">
					<?php _e( "What's New", 'halt' ); ?>
				</a><a class="nav-tab nav-tab-active" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'halt-credits' ), 'index.php' ) ) ); ?>">
					<?php _e( 'Credits', 'halt' ); ?>
				</a>
			</h2>

			<p class="about-description"><?php _e( 'Halt is created with an aim to provide the #1 customer portal for your users through WordPress.', 'halt' ); ?></p>

			<?php echo $this->contributors(); ?>
		</div>
		<?php
	}

	/**
	 * Render Contributors List
	 *
	 * @since 1.4
	 * @uses Halt_Welcome::get_contributors()
	 * @return string $contributor_list HTML formatted list of all the contributors for Halt
	 */
	public function contributors() {
		$contributors = $this->get_contributors();

		if ( empty( $contributors ) )
			return '';

		$contributor_list = '<ul class="wp-people-group">';

		foreach ( $contributors as $contributor ) {
			$contributor_list .= '<li class="wp-person">';
			$contributor_list .= sprintf( '<a href="%s" title="%s">',
				esc_url( 'https://github.com/' . $contributor->login ),
				esc_html( sprintf( __( 'View %s', 'halt' ), $contributor->login ) )
			);
			$contributor_list .= sprintf( '<img src="%s" width="64" height="64" class="gravatar" alt="%s" />', esc_url( $contributor->avatar_url ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= sprintf( '<a class="web" href="%s">%s</a>', esc_url( 'https://github.com/' . $contributor->login ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= '</li>';
		}

		$contributor_list .= '</ul>';

		return $contributor_list;
	}

	/**
	 * Retreive list of contributors from GitHub.
	 *
	 * @access public
	 * @since 1.4
	 * @return array $contributors List of contributors
	 */
	public function get_contributors() {
		$contributors = get_transient( 'halt_contributors' );

		if ( false !== $contributors )
			return $contributors;

		$response = wp_remote_get( 'https://api.github.com/repos/mauryaratan/halt/contributors', array( 'sslverify' => false ) );

		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) )
			return array();

		$contributors = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! is_array( $contributors ) )
			return array();

		set_transient( 'halt_contributors', $contributors, 3600 );

		return $contributors;
	}

	/**
	 * Sends user to the Welcome page on first activation of Halt as well as each
	 * time Halt is upgraded to a new version
	 *
	 * @access public
	 * @since 1.0
	 * @global $halt_options Array of all the Halt Options
	 * @return void
	 */
	public function welcome() {
		global $halt_options;

		// Bail if no activation redirect
		if ( ! get_transient( '_halt_activation_redirect' ) )
			return;

		// Delete the redirect transient
		delete_transient( '_halt_activation_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
			return;

		wp_safe_redirect( admin_url( 'index.php?page=halt-about' ) ); exit;
	}
}
new Halt_Welcome();
