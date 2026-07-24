<?php
/**
 * Plugin Name: Woo Agency Toolkit
 * Plugin URI:  https://github.com/alexphex/woo-agency-toolkit
 * Description: WooCommerce extensions for agency projects — custom product fields, checkout fields, order columns and email customization.
 * Version:     1.0.0
 * Author:      alex_dev
 * Author URI:  https://github.com/alexphex
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: woo-agency-toolkit
 * Domain Path: /languages
 * Requires Plugins: woocommerce
 *
 * @package Woo_Agency_Toolkit
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WAT_VERSION', '1.0.0' );
define( 'WAT_DIR', plugin_dir_path( __FILE__ ) );
define( 'WAT_URL', plugin_dir_url( __FILE__ ) );

/**
 * Autoloader for plugin classes.
 *
 * @param string $class_name Class name to load.
 */
function wat_autoloader( string $class_name ): void {
    $prefix = 'WAT_';

    if ( strpos( $class_name, $prefix ) !== 0 ) {
        return;
    }

    $relative = substr( $class_name, strlen( $prefix ) );
    $file     = WAT_DIR . 'includes/class-' . strtolower( str_replace( '_', '-', $relative ) ) . '.php';

    if ( file_exists( $file ) ) {
        require_once $file;
    }
}
spl_autoload_register( 'wat_autoloader' );

/**
 * Initialize the plugin.
 */
function wat_init(): void {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    new WAT_Product_Fields();
    new WAT_Checkout_Fields();
    new WAT_Order_Columns();
    new WAT_Order_Email();
}
add_action( 'plugins_loaded', 'wat_init' );
