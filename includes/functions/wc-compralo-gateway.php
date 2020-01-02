<?php

/**
 * Register payments methods in gateway.
 *
 * @link       https://github.com/compralo/woocommerce-plugin
 * @since      1.0.0
 * 
 * @package    wc-compralo
 * @subpackage wc-compralo/includes/functions/gateway/
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! function_exists( 'wc_compralo_gateway_methods' ) ) {

/**
 * Gateway add methods function
 *
 * @since    1.0.0
 * @param    array    Current array of registered payment methods
 * @return   array    Updated array of registered payment methods
 */
	function wc_compralo_gateway_methods( $payment_methods ) 
	{
		
	$payment_methods[] = 'Wc_Compralo_Gateway_Method_Redirect';
		
	return $payment_methods;
	
	}

}