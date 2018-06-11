<?php

/**
 * Class WP_EXT_Customer_User_Role
 * ------------------------------------------------------------------------------------------------------------------ */

class WP_EXT_Customer_User_Role extends WP_EXT_Customer {

	/**
	 * Post type: `capabilities`.
	 *
	 * @var array
	 * -------------------------------------------------------------------------------------------------------------- */

	private $cap;

	/**
	 * Constructor.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function __construct() {
		parent::__construct();

		// Capabilities.
		$this->cap = self::capabilities();

		// Initialize.
		$this->run();
	}

	/**
	 * Plugin: `initialize`.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function run() {
		add_action( 'admin_init', [ $this, 'caps_admin' ], 9999 );
		add_action( 'admin_init', [ $this, 'caps_pt' ], 9999 );
	}

	/**
	 * Plugin: `install`.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function install() {
		add_role( $this->cap_type[0], esc_html__( 'PT: Customer', 'wp-ext-' . $this->domain_ID ), [
			'read'         => true,
			'upload_files' => true,
		] );
	}

	/**
	 * Plugin: `uninstall`.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function uninstall() {
		$admin = get_role( 'administrator' );

		if ( get_role( $this->cap_type[0] ) ) {
			remove_role( $this->cap_type[0] );
		}

		foreach ( $this->cap as $cap ) {
			$admin->remove_cap( $cap );
		}
	}

	/**
	 * Capabilities: `admin`.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function caps_admin() {
		$admin = get_role( 'administrator' );

		foreach ( $this->cap as $cap ) {
			$admin->add_cap( $cap );
		}
	}

	/**
	 * Capabilities: `cpt`.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function caps_pt() {
		$pt_role = get_role( $this->cap_type[0] );

		$pt_role->add_cap( $this->cap['delete_posts'], true );
		$pt_role->add_cap( $this->cap['delete_published_posts'], true );
		$pt_role->add_cap( $this->cap['edit_posts'], true );
		$pt_role->add_cap( $this->cap['edit_published_posts'], true );
		$pt_role->add_cap( $this->cap['publish_posts'], false );
	}
}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @return WP_EXT_Customer_User_Role
 * ------------------------------------------------------------------------------------------------------------------ */

function WP_EXT_Customer_User_Role() {
	static $object;

	if ( null == $object ) {
		$object = new WP_EXT_Customer_User_Role;
	}

	return $object;
}

/**
 * Install plugin.
 * ------------------------------------------------------------------------------------------------------------------ */

register_activation_hook( plugin_dir_path( __DIR__ ) . 'plugin.php', [ WP_EXT_Customer_User_Role(), 'install' ] );

/**
 * Uninstall plugin.
 * ------------------------------------------------------------------------------------------------------------------ */

register_deactivation_hook( plugin_dir_path( __DIR__ ) . 'plugin.php', [ WP_EXT_Customer_User_Role(), 'uninstall' ] );

/**
 * Initialize the object on `plugins_loaded`.
 * ------------------------------------------------------------------------------------------------------------------ */

add_action( 'plugins_loaded', [ WP_EXT_Customer_User_Role(), 'run' ] );
