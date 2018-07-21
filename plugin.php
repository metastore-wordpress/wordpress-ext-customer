<?php
/**
 * Plugin Name:     (WP-EXT) Customer
 * Plugin URI:      https://metastore.pro/
 *
 * Description:     Customer post type and more.
 *
 * Author:          Kitsune Solar
 * Author URI:      https://kitsune.solar/
 *
 * Version:         1.0.0
 *
 * Text Domain:     wp-ext-customer
 * Domain Path:     /languages
 *
 * License:         GPLv3
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Loading `WP_EXT_Customer`.
 */

function run_wp_ext_customer() {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Customer.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Customer_Post_Type.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Customer_Post_Field.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Customer_Taxonomy.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Customer_User_Role.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Customer_Theme.class.php' );
//  require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Customer_Template.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Customer_ShortCode.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Customer_Widget.class.php' );
}

run_wp_ext_customer();
