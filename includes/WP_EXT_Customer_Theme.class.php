<?php

/**
 * Class WP_EXT_Customer_Theme
 * ------------------------------------------------------------------------------------------------------------------ */

class WP_EXT_Customer_Theme extends WP_EXT_Customer {

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
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_style' ], 92 );
		add_filter( 'body_class', [ $this, 'body_class' ] );
	}

	/**
	 * Enqueue style.
	 * -------------------------------------------------------------------------------------------------------------- */

	public function enqueue_style() {
		if ( ! is_admin() ) {
			wp_enqueue_style( 'ext-plugin-' . $this->domain_ID, plugins_url( 'themes/styles/theme.css', __DIR__ ), [], '' );
		}
	}

	/**
	 * Body class.
	 *
	 * @param $classes
	 *
	 * @return array
	 * -------------------------------------------------------------------------------------------------------------- */

	public function body_class( $classes ) {
		if ( ! is_admin() && ( is_singular( $this->pt_ID ) || is_post_type_archive( $this->pt_ID ) ) ) {
			$classes[] = 'wp-ext-' . $this->pt_ID;
		}

		return $classes;
	}
}

/**
 * Helper function to retrieve the static object without using globals.
 *
 * @return WP_EXT_Customer_Theme
 * ------------------------------------------------------------------------------------------------------------------ */

function WP_EXT_Customer_Theme() {
	static $object;

	if ( null == $object ) {
		$object = new WP_EXT_Customer_Theme;
	}

	return $object;
}

/**
 * Initialize the object on `plugins_loaded`.
 * ------------------------------------------------------------------------------------------------------------------ */

add_action( 'plugins_loaded', [ WP_EXT_Customer_Theme(), 'run' ] );
