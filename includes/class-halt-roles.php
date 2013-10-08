<?php
/**
 * Roles and Capabilities
 *
 * @package     Halt
 * @subpackage  Classes/Roles
 * @author   	Ram Ratan Maurya
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
*/

/**
 * Halt_Roles Class.
 *
 * This class handles the role creation and assignment of capabilities for those roles.
 *
 * These roles let us have Support Staff etc, each of whom can do certain things within
 * the Halt.
 */
class Halt_Roles {
	/**
	 * Get things going
	 *
	 * @see Halt_Roles::add_roles()
	 * @see Halt_Roles::add_caps()
	 */
	public function __construct() {
		$this->add_roles();
		$this->add_caps();
	}
	/**
	 * Add new shop roles with default WP caps
	 *
	 * @access public
	 * @return void
	 */
	public function add_roles() {
		add_role( 'support_staff', __( 'Support Staff', 'halt' ), array(
			'read'                   => true,
			'edit_posts'             => true,
			'delete_posts'           => true,
			'unfiltered_html'        => true,
			'upload_files'           => true,
			'export'                 => true,
			'import'                 => true,
			'delete_others_pages'    => true,
			'delete_others_posts'    => true,
			'delete_pages'           => true,
			'delete_private_pages'   => true,
			'delete_private_posts'   => true,
			'delete_published_pages' => true,
			'delete_published_posts' => true,
			'edit_others_pages'      => true,
			'edit_others_posts'      => true,
			'edit_pages'             => true,
			'edit_private_pages'     => true,
			'edit_private_posts'     => true,
			'edit_published_pages'   => true,
			'edit_published_posts'   => true,
			'manage_categories'      => true,
			'manage_links'           => true,
			'moderate_comments'      => true,
			'publish_pages'          => true,
			'publish_posts'          => true,
			'read_private_pages'     => true,
			'read_private_posts'     => true
		) );
	}

	/**
	 * Add new shop-specific capabilities.
	 *
	 * @access public
	 * @global object $wp_roles
	 * @return void
	 */
	public function add_caps() {
		global $wp_roles;

		if ( class_exists('WP_Roles') )
			if ( ! isset( $wp_roles ) )
				$wp_roles = new WP_Roles();

		if ( is_object( $wp_roles ) ) {
			/** Support Staff Capabilities */
			$wp_roles->add_cap( 'support_staff', 'manage_halt' );
			$wp_roles->add_cap( 'support_staff', 'manage_halt_tickets' );
			$wp_roles->add_cap( 'support_staff', 'manage_halt_articles' );

			/** Site Administrator Capabilities */
			$wp_roles->add_cap( 'administrator', 'manage_halt' );
			$wp_roles->add_cap( 'administrator', 'manage_halt_tickets' );
			$wp_roles->add_cap( 'administrator', 'manage_halt_articles' );
		}

		// Add the main post type capabilities
		$capabilities = $this->get_core_caps();
		foreach ( $capabilities as $cap_group ) {
			foreach ( $cap_group as $cap ) {
				$wp_roles->add_cap( 'support_staff', $cap );
				$wp_roles->add_cap( 'administrator', $cap );
			}
		}
	}

	/**
	 * Gets the core post type capabilities
	 *
	 * @access public
	 * @return array $capabilities Core post type capabilities
	 */
	public function get_core_caps() {
		$capabilities = array();

		$capability_types = array( 'ticket', 'article' );

		foreach ( $capability_types as $capability_type ) {
			$capabilities[ $capability_type ] = array(
				// Post type
				"edit_{$capability_type}",
				"read_{$capability_type}",
				"delete_{$capability_type}",
				"edit_{$capability_type}s",
				"edit_others_{$capability_type}s",
				"publish_{$capability_type}s",
				"read_private_{$capability_type}s",
				"delete_{$capability_type}s",
				"delete_private_{$capability_type}s",
				"delete_published_{$capability_type}s",
				"delete_others_{$capability_type}s",
				"edit_private_{$capability_type}s",
				"edit_published_{$capability_type}s",

				// Terms
				"manage_{$capability_type}_terms",
				"edit_{$capability_type}_terms",
				"delete_{$capability_type}_terms",
				"assign_{$capability_type}_terms"
			);
		}

		return $capabilities;
	}

	/**
	 * Remove core post type capabilities (called on uninstall)
	 *
	 * @access public
	 * @return void
	 */
	public function remove_caps() {
		if ( class_exists( 'WP_Roles' ) )
			if ( ! isset( $wp_roles ) )
				$wp_roles = new WP_Roles();

		if ( is_object( $wp_roles ) ) {
			/** Support Staff Capabilities */
			$wp_roles->remove_cap( 'support_staff', 'manage_halt' );
			$wp_roles->remove_cap( 'support_staff', 'manage_halt_tickets' );
			$wp_roles->remove_cap( 'support_staff', 'manage_halt_articles' );

			/** Site Administrator Capabilities */
			$wp_roles->remove_cap( 'administrator', 'manage_halt' );
			$wp_roles->remove_cap( 'administrator', 'manage_halt_tickets' );
			$wp_roles->remove_cap( 'administrator', 'manage_halt_articles' );
		}

		/** Remove the Main Post Type Capabilities */
		$capabilities = $this->get_core_caps();

		foreach ( $capabilities as $cap_group ) {
			foreach ( $cap_group as $cap ) {
				$wp_roles->remove_cap( 'support_staff', $cap );
				$wp_roles->remove_cap( 'administrator', $cap );
			}
		}
	}
}
