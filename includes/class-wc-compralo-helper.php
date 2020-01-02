<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Wc_Compralo_Helper' ) ) {

/**
 * The plugin helper class
 *
 * @link       https://github.com/compralo/woocommerce-plugin
 * @since      1.0.0
 * 
 * @package    wc-compralo
 * @subpackage wc-compralo/includes/
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 */
	class Wc_Compralo_Helper 
	{

	/**
	 * Find out if an PHP extension is loaded or return all extensions on the system
	 *
	 * @since    1.0.0
	 * @param    string    $name    The extension name
	 * @return   array|boolean
	 */
		public static function php_extension( $name = NULL ) 
		{

		if ( NULL === $name ) :
			
			$all_loaded_extensions = get_loaded_extensions();
			
			// If the parameter is not passed Returns an array with the names of all modules
			return $all_loaded_extensions;

		else :
			
			$is_extension_loaded = extension_loaded( $name );

			return $is_extension_loaded;

		endif;
		
		}

	/**
	 * Return active plugins data or all installed plugins data
	 *
	 * @since    1.0.0
	 * @param    boolean    $all_plugins   Select all plugins or only those enabled
	 * @return   array      Plugins list
	 */
		public static function wp_plugins( $all_plugins = FALSE ) 
		{

		$active_plugins_data     =  [];
		$install_plugins_data    =  get_plugins();
		$active_plugins_key      =  get_option( 'active_plugins' );

		if ( TRUE === $all_plugins ) :

			// Return all installed plugins in WordPress
			return $install_plugins_data;

		else :
			
			// Filter active plugins in all installed plugins
			foreach ( $active_plugins_key as $index => $plugin ) :
				
				if ( array_key_exists( $plugin, $install_plugins_data ) ) {
					
					// Array Formatting
					$active_plugins_data[$plugin] = $install_plugins_data[$plugin];
					
				}
			
			endforeach;

			// Return all active plugins in WordPress
			return $active_plugins_data;

		endif;
		
		}

	/**
	 * Return WooCommerce version
	 *
	 * @since    1.0.0
	 * @return   string|null   The WooCommerce version
	 */
		public static function wc_version() 
		{

		$is_woocommerce_activated = class_exists ( 'WC_Payment_Gateway' );

		//Check if WooCommerce class exists and gets WooCommerce version
		if ( $is_woocommerce_activated && property_exists( WC(), 'version' ) ) :
		
			return WC()->version;

		endif;

		return NULL;
		
		}

		/**
		 * Checks if WC version is less than passed in version.
		 *
		 * @since  4.1.11
		 * @param  string   $version   Version to check against.
		 * @return bool
		 */
		public static function is_wc_lt( $version ) {
			
		return version_compare( WC_VERSION, $version, '<' );
		
		}

	}
}