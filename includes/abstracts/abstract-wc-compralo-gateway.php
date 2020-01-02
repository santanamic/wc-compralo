<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Wc_Compralo_Gateway' ) ) {

/**
 * Abstract class that will be inherited by all payment methods in gateway.
 *
 * @link       https://github.com/compralo/woocommerce-plugin
 * @since      1.0.0
 *
 * @package    Wc_Compralo
 * @subpackage Wc_Compralo/includes/abstracts/
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 */
	abstract class Wc_Compralo_Gateway extends WC_Payment_Gateway 
	{
		
	/**
	 * The Compralo key.
	 *
	 * @access   protected
	 * @since    1.0.0
	 * @var      string
	 */
		protected $api_key;

	/**
	 * The Compralo Api.
	 *
	 * @access   protected
	 * @since    1.0.0
	 * @var      Wc_Compralo_Api   The API class API for integration.
	 */
		protected $api;
		
	/**
	 * Init payment method.
	 *
	 * @access   private
	 * @since    1.0.0
	 * @param    string    $environment     Environment type, use sandbox or production.
	 * @return   void
	 */
		protected function init_gateway() 
		{

		// Build class attributes for plugin options.
		$this->init_form_fields();
		$this->init_settings();
		
		// Define gateway set variables.
		$this->title              = $this->get_option( 'title' );
		$this->description        = $this->get_option( 'description' );
		$this->enabled            = 'yes' === $this->get_option( 'enabled' );

		// Define plugin set variables.
		$this->debug              = $this->get_option( 'debug' );
		$this->is_sandbox         = $this->get_option( 'testmode' );

		// Load gateway methods.
		$this->init_api();
		$this->init_hooks();
		$this->require();

		}

		/**
	 * Init API.
	 *
	 * @access   private
	 * @since    1.0.0
	 * @return   void
	 */
		private function init_api() 
		{
		
		$this->api = wc_compralo()->api();

		if ( $this->is_sandbox != 'yes' ) {

			$this->api_key = $this->get_option( 'key_production' );

		} 

		else {

			$this->api_key = $this->get_option( 'key_sandbox' );

		}

		$this->api->set_api_key( $this->api_key );
		
		}
	}
}