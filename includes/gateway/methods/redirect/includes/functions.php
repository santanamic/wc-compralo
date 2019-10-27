<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Functions for payment method.
 *
 * @link       https://github.com/compralo/woocommerce-plugin
 * @since      1.0.0
 * 
 * @package    wc-compralo
 * @subpackage wc-compralo/includes/gateway/methods/redirect/
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 */
 
if ( ! function_exists( 'wc_compralo_method_redirect_admin_enqueue' ) ) {

/**
 * Register admin styles and scripts for payment method
 *
 * @since    1.0.0
 * @return   array    void
 */
	function wc_compralo_method_redirect_admin_enqueue() 
	{

	wp_enqueue_script( 'wc-compralo-method-redirect-admin', 
		WC_COMPRALO_URI . 'includes/gateway/methods/redirect/assets/admin/js/script.js' );
	wp_enqueue_style( 'wc-compralo-method-redirect-admin', 
		WC_COMPRALO_URI . 'includes/gateway/methods/redirect/assets/admin/css/style.css' );

	}

}

if ( ! function_exists( 'wc_compralo_method_redirect_public_enqueue' ) ) {

/**
 * Register public styles and scripts for payment method
 *
 * @since    1.0.0
 * @return   array    void
 */
	function wc_compralo_method_redirect_public_enqueue() 
	{

	wp_enqueue_script( 'wc-compralo-method-redirect', 
		WC_COMPRALO_URI . 'includes/gateway/methods/redirect/assets/public/js/script.js' );
	wp_enqueue_style( 'wc-compralo-method-redirect', 
		WC_COMPRALO_URI . 'includes/gateway/methods/redirect/assets/public/css/style.css' );

	}

}