<?php

/**
 * Register styles and scripts in admin panel.
 *
 * @link       https://github.com/compralo/woocommerce-plugin
 * @since      1.0.0
 * 
 * @package    wc-compralo
 * @subpackage wc-compralo/includes/functions/admin/
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! function_exists( 'wc_compralo_admin_enqueue_script' ) ) {

/**
 * Register scripts in WP admin
 *
 * @since    1.0.0
 * @return   array    void
 */
	function wc_compralo_admin_enqueue_script() 
	{
	
	wp_enqueue_script( 'wc-compralo-admin', WC_COMPRALO_URI . 'admin/assets/js/script.js' );

	}

}

if ( ! function_exists( 'wc_compralo_admin_enqueue_styles' ) ) {

/**
 * Register styles in WP admin
 *
 * @since    1.0.0
 * @return   array    void
 */
	function wc_compralo_admin_enqueue_styles() 
	{

	wp_enqueue_style( 'wc-compralo-admin', WC_COMPRALO_URI . 'admin/assets/css/style.css' );

	}

}

if ( ! function_exists( 'wc_compralo_admin_links' ) ) {

	/**
	 * Add link shortcut in admin page
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	function wc_compralo_admin_links( $links ) 
	{

	$links[] = '<a href="' . esc_url( admin_url('admin.php?page=wc-settings&tab=checkout&section=wc_compralo_redirect' ) ) . '">' . __( 'Settings', 'wc-compralo' ) . '</a>';
	$links[] = '<a href="https://compralo.freshdesk.com/support/tickets/new">' . __('Support', 'wc-compralo') . '</a>';
	
	return $links;
	
	}
	
}