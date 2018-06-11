<?php

/**
 * Class WP_EXT_Customer_Template
 * ------------------------------------------------------------------------------------------------------------------ */

class WP_EXT_Customer_Template extends WP_EXT_Customer {

	/**
	 * Constructor.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function __construct() {
		parent::__construct();

		$this->run();
	}

	/**
	 * Plugin: `initialize`.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function run() {
		add_filter( 'single_template', [ $this, 'template_single' ] );
		add_filter( 'archive_template', [ $this, 'template_archive' ] );
	}

	/**
	 * Template: `single`.
	 *
	 * @param $single_template
	 * @param int $id
	 *
	 * @return string
	 * -------------------------------------------------------------------------------------------------------------- */

	public function template_single( $single_template, $id = 0 ) {
		$post = get_post( $id );

		if ( $post->post_type === $this->pt_ID ) {
			$single_template = locate_template( 'ext-templates/' . $this->pt_ID . '-node-single.php' );
		}

		return $single_template;
	}

	/**
	 * Template: `archive`.
	 *
	 * @param $archive_template
	 *
	 * @return string
	 * -------------------------------------------------------------------------------------------------------------- */

	public function template_archive( $archive_template ) {
		if ( is_post_type_archive( $this->pt_ID ) ) {
			$archive_template = locate_template( 'ext-templates/' . $this->pt_ID . '-node-storage.php' );
		}

		return $archive_template;
	}
}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @return WP_EXT_Customer_Template
 * ------------------------------------------------------------------------------------------------------------------ */

function WP_EXT_Customer_Template() {
	static $object;

	if ( null == $object ) {
		$object = new WP_EXT_Customer_Template;
	}

	return $object;
}

/**
 * Initialize the object on `plugins_loaded`.
 * ------------------------------------------------------------------------------------------------------------------ */

add_action( 'plugins_loaded', [ WP_EXT_Customer_Template(), 'run' ] );
