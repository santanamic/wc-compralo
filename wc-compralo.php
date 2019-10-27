<?php

/**
 * Plugin Name:       Compralo for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/wc-compralo
 * Description:       Take payments on Bitcoins and other Cryptocurrencies using Compralo.
 * Version:           1.0.1
 * Author:            WILLIAN SANTANA
 * Author URI:        https://github.com/santanamic
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-compralo
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

define( 'WC_COMPRALO_NAME', 'WooCommerce Compralo' );
define( 'WC_COMPRALO_VERSION', '1.0.0' );
define( 'WC_COMPRALO_DEBUG_OUTPUT', 0 );
define( 'WC_COMPRALO_BASENAME', plugin_basename( __FILE__ ) );
define( 'WC_COMPRALO_SLUG', plugin_basename( plugin_dir_path( __FILE__ ) ) );
define( 'WC_COMPRALO_CORE_FILE', __FILE__ );
define( 'WC_COMPRALO_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WC_COMPRALO_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

require_once( WC_COMPRALO_PATH . 'vendor/autoload.php' );

/**
 * The code that runs during plugin activation and The code that runs during plugin deactivation.
 */
register_activation_hook( __FILE__, 'wc_compralo_plugin_activate' );
register_deactivation_hook( __FILE__, 'wc_compralo_plugin_deactivate' );

/**
 * Initial hook for plugin run and Initial hook for plugin internationalization.
 */
add_action( 'plugins_loaded', 'wc_compralo' );
add_action( 'plugins_loaded', 'wc_compralo_plugin_i18n' );

/**
 * Initial hook for gateway run.
 */
add_action( 'woocommerce_payment_gateways', 'wc_compralo_gateway_methods' );

/**
 * Initial hook for add admin scripts and styles.
 */
add_filter( 'plugin_action_links_' . WC_COMPRALO_BASENAME, 'wc_compralo_admin_links' );
add_action( 'admin_enqueue_scripts', 'wc_compralo_admin_enqueue_script' );
add_action( 'admin_enqueue_scripts', 'wc_compralo_admin_enqueue_styles' );
