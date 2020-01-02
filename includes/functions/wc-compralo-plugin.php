<?php

/**
 * Fired during plugin activation.
 *
 * @link       https://github.com/compralo/woocommerce-plugin
 * @since      1.0.0
 * 
 * @package    wc-compralo
 * @subpackage wc-compralo/includes/functions
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! function_exists( 'wc_compralo_plugin_activate' ) ) {

	/**
	 * Plugin activate call function
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	function wc_compralo_plugin_activate() 
	{

	}

}

if ( ! function_exists( 'wc_compralo_plugin_deactivate' ) ) {

	/**
	 * Plugin deactivation call function
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	function wc_compralo_plugin_deactivate() 
	{

	}
	
}

if ( ! function_exists( 'wc_compralo_plugin_i18n' ) ) {

	/**
	 * Load the plugin text domain for translation
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	function wc_compralo_plugin_i18n() 
	{

	load_plugin_textdomain( 'wc-compralo', false, WC_COMPRALO_SLUG . '/languages/' );
	
	}
	
}

if ( ! function_exists( 'wc_compralo' ) ) {

	/**
	 * Begins execution of the plugin.
	 *
	 * @since    1.0.0
	 * @return   Wc_Compralo
	 */
	function wc_compralo() 
	{
		
	$plugin = Wc_Compralo::instance();
		
	return $plugin;
	
	}

}