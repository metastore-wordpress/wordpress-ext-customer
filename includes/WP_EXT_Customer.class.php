<?php

/**
 * Class WP_EXT_Customer
 */
class WP_EXT_Customer {

	/**
	 * Textdomain used for translation.
	 *
	 * @var string
	 */
	protected $domain_ID;

	/**
	 * Post type name.
	 *
	 * @var string
	 */
	protected $pt_ID;

	/**
	 * Post type archive name.
	 *
	 * @var string
	 */
	protected $archive_ID;

	/**
	 * Post type capability type.
	 *
	 * @var string
	 */
	protected $cap_type;

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Settings.
		$this->pt_ID      = 'customer';
		$this->archive_ID = 'customers';
		$this->domain_ID  = 'customer';
		$this->cap_type   = [ 'pt_customer', 'pt_customers' ];

		// Languages.
		self::languages();

		// Initialize.
		$this->run();
	}

	/**
	 * Plugin: `initialize`.
	 */
	public function run() {
	}

	/**
	 * Plugin: `languages`.
	 */
	public function languages() {
		load_plugin_textdomain(
			'wp-ext-' . $this->domain_ID,
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages/'
		);
	}

	/**
	 * Post type: `capabilities`.
	 *
	 * @return array
	 */
	public function capabilities() {
		$capabilities = [
			'edit_post'              => 'edit_' . $this->cap_type[0],
			'read_post'              => 'read_' . $this->cap_type[0],
			'delete_post'            => 'delete_' . $this->cap_type[0],
			'edit_posts'             => 'edit_' . $this->cap_type[1],
			'edit_others_posts'      => 'edit_others_' . $this->cap_type[1],
			'edit_published_posts'   => 'edit_published_' . $this->cap_type[1],
			'edit_private_posts'     => 'edit_private_' . $this->cap_type[1],
			'delete_posts'           => 'delete_' . $this->cap_type[1],
			'delete_others_posts'    => 'delete_others_' . $this->cap_type[1],
			'delete_published_posts' => 'delete_published_' . $this->cap_type[1],
			'delete_private_posts'   => 'delete_private_' . $this->cap_type[1],
			'publish_posts'          => 'publish_' . $this->cap_type[1],
			'read_private_posts'     => 'read_private_' . $this->cap_type[1],
			'moderate_comments'      => 'moderate_' . $this->cap_type[0] . '_comments',
		];

		return $capabilities;
	}

}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @return WP_EXT_Customer
 */
function WP_EXT_Customer() {
	static $object;

	if ( null == $object ) {
		$object = new WP_EXT_Customer;
	}

	return $object;
}

/**
 * Initialize the object on `plugins_loaded`.
 */
add_action( 'plugins_loaded', [ WP_EXT_Customer(), 'run' ] );
