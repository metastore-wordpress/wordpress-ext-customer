<?php

/**
 * Class WP_EXT_Customer_Post_Type
 */
class WP_EXT_Customer_Post_Type extends WP_EXT_Customer {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->run();
	}

	/**
	 * Plugin: `initialize`.
	 */
	public function run() {
		add_action( 'init', [ $this, 'post_type' ], 0 );
		add_action( 'init', [ $this, 'post_rewrite' ] );
		add_filter( 'post_type_link', [ $this, 'post_link' ], 10, 3 );
	}

	/**
	 * Post type: `customer`.
	 */
	public function post_type() {
		$labels       = [
			'name'                  => _x( 'Заказчики', 'Customer General Name', 'wp-ext-' . $this->domain_ID ),
			'singular_name'         => _x( 'Заказчик', 'Customer Singular Name', 'wp-ext-' . $this->domain_ID ),
			'menu_name'             => __( 'Заказчики', 'wp-ext-' . $this->domain_ID ),
			'name_admin_bar'        => __( 'Заказчик', 'wp-ext-' . $this->domain_ID ),
			'archives'              => __( 'Item Archives', 'wp-ext-' . $this->domain_ID ),
			'attributes'            => __( 'Item Attributes', 'wp-ext-' . $this->domain_ID ),
			'parent_item_colon'     => __( 'Parent Item:', 'wp-ext-' . $this->domain_ID ),
			'all_items'             => __( 'All Items', 'wp-ext-' . $this->domain_ID ),
			'add_new_item'          => __( 'Add New Item', 'wp-ext-' . $this->domain_ID ),
			'add_new'               => __( 'Add New', 'wp-ext-' . $this->domain_ID ),
			'new_item'              => __( 'New Item', 'wp-ext-' . $this->domain_ID ),
			'edit_item'             => __( 'Edit Item', 'wp-ext-' . $this->domain_ID ),
			'update_item'           => __( 'Update Item', 'wp-ext-' . $this->domain_ID ),
			'view_item'             => __( 'View Item', 'wp-ext-' . $this->domain_ID ),
			'view_items'            => __( 'View Items', 'wp-ext-' . $this->domain_ID ),
			'search_items'          => __( 'Search Item', 'wp-ext-' . $this->domain_ID ),
			'not_found'             => __( 'Not found', 'wp-ext-' . $this->domain_ID ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-ext-' . $this->domain_ID ),
			'featured_image'        => __( 'Featured Image', 'wp-ext-' . $this->domain_ID ),
			'set_featured_image'    => __( 'Set featured image', 'wp-ext-' . $this->domain_ID ),
			'remove_featured_image' => __( 'Remove featured image', 'wp-ext-' . $this->domain_ID ),
			'use_featured_image'    => __( 'Use as featured image', 'wp-ext-' . $this->domain_ID ),
			'insert_into_item'      => __( 'Insert into item', 'wp-ext-' . $this->domain_ID ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'wp-ext-' . $this->domain_ID ),
			'items_list'            => __( 'Items list', 'wp-ext-' . $this->domain_ID ),
			'items_list_navigation' => __( 'Items list navigation', 'wp-ext-' . $this->domain_ID ),
			'filter_items_list'     => __( 'Filter items list', 'wp-ext-' . $this->domain_ID ),
		];
		$capabilities = self::capabilities();
		$rewrite      = [
			'slug'       => '',
			'with_front' => false,
			'pages'      => true,
			'feeds'      => true,
		];
		$args         = [
			'label'               => __( 'Заказчик', 'wp-ext-' . $this->domain_ID ),
			'description'         => __( 'Customer Description', 'wp-ext-' . $this->domain_ID ),
			'labels'              => $labels,
			'supports'            => [ 'title', 'editor' ],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => $this->archive_ID,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capabilities'        => $capabilities,
			'map_meta_cap'        => true,
			'rewrite'             => $rewrite,
		];
		register_post_type( $this->pt_ID, $args );
	}

	/**
	 * Rewrite rules.
	 */
	public function post_rewrite() {
		add_rewrite_rule(
			$this->pt_ID . '/([0-9]+)?$',
			'index.php?post_type=' . $this->pt_ID . '&p=$matches[1]',
			'top'
		);
	}

	/**
	 * Post slug.
	 *
	 * @param $url
	 * @param int $id
	 *
	 * @return string
	 */
	public function post_link( $url, $id = 0 ) {
		$post    = get_post( $id );
		$post_ID = $post->ID;

		if ( $this->pt_ID != $post->post_type ) {
			return $url;
		}

		try {
			$slug = home_url( user_trailingslashit( $this->pt_ID . '/' . $post_ID . '/' ) );

			return $slug;
		} catch ( Exception $e ) {
			return $url;
		}

	}
}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @return WP_EXT_Customer_Post_Type
 */
function WP_EXT_Customer_Post_Type() {
	static $object;

	if ( null == $object ) {
		$object = new WP_EXT_Customer_Post_Type;
	}

	return $object;
}

/**
 * Initialize the object on `plugins_loaded`.
 */
add_action( 'plugins_loaded', [ WP_EXT_Customer_Post_Type(), 'run' ] );
