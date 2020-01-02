<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Wc_Compralo_Gateway_Method_Redirect' ) ) {

/**
 * Redirect payment method.
 *
 * @link       https://github.com/compralo/woocommerce-plugin
 * @since      1.0.0
 *
 * @package    wc-compralo
 * @subpackage wc-compralo/includes/gateway/methods/
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 */
	class Wc_Compralo_Gateway_Method_Redirect extends Wc_Compralo_Gateway 
	{

	/**
	 * Start payment method.
	 *
	 * @since    1.0.0
	 */
		public function __construct() 
		{

		// Define admin set variables.
		$this->id                 = 'wc_compralo_redirect';
		$this->method_title       = __( 'Compralo Redirect', 'wc-compralo' );
		$this->method_description = __( 'Accepts payments on cryptocurrencies using Compralo.', 'wc-compralo' );
		$this->icon               = plugins_url( 'assets/public/img/logo.png', __FILE__ );
		$this->has_fields         = FALSE;

		parent::init_gateway();

		}

	/**
	 * Set gateway forms fields ( Plugin admin options ).
	 *
	 * @access   public
	 * @since    1.0.0
	 * @return   void
	 */

		public function init_form_fields()
		{

		$fields = array(
			'enabled' => array(
				'title'       => __( 'Enable/Disable', 'wc-compralo' ),
				'label'       => __( 'Check to enable this form of payment.', 'wc-compralo' ),
				'type'        => 'checkbox',
				'description' => '',
				'default'     => 'no'
              ),
			'title' => array(
				'title'       => __( 'Checkout Title', 'wc-compralo' ),
				'type'        => 'text',
				'description' => __( 'This controls the title the user sees during checkout.', 'wc-compralo' ),
				'default'     => 'Compralo Redirect',
				'desc_tip'    => true,
              ),
			 'description' => array(
				'title'       => __( 'Checkout Description', 'wc-compralo' ),
				'type'        => 'textarea',
				'description' => __( 'This controls the description the user sees during checkout.', 'wc-compralo' ),
				'desc_tip'    => true,
				'default'     => __( 'Pay with Bitcoin e Other Cryptocurrencies using Compralo.' ), 
			  ),
			 'credentials' => array(
				'title'       => __( 'Integration Settings', 'wc-compralo' ),
				'type'        => 'title',
				'description' =>  __( 'Enter your API credentials to process payments using Compralo. Contact Compralo support 
					for access credentials.', 'wc-compralo' ),
			),
			 'testmode' => array(
				'title'		  => __( 'Sandbox Environment', 'wc-compralo' ),
				'type'		  => 'checkbox',
				'label'		  => __( 'Enable the Compralo API Testing.', 'wc-compralo' ),
				'default'     => 'no',
				'custom_attributes' => array( 'disabled' => 'disabled' ),
			),
			'key_production' => array(
				'title'       => 'API KEY',
				'type'        => 'text',
              ),
			'key_sandbox' => array(
				'title'       => 'Sandbox API KEY',
				'type'        => 'text'
			),
			'debug' => array(
				'title'       => __('Enable Log', 'wc-compralo'),
				'type'        => 'checkbox',
				'label'       => __('Enable Log', 'wc-compralo'),
				'default'     => 'no',
				'description' => sprintf(__('Logs plugin events through the <code>% s </code> file. Note: This may record personal information. We recommend using this for debugging purposes only and to delete these records after finalization.', 'wc-compralo'), \WC_Log_Handler_File::get_log_file_path( $this->id ) ),
			  ),
		);

		$this->form_fields = $fields;

		}

	/**
	 * Processes the user data after sending the payment request in checkout.	
	 *
	 * @access   public
	 * @since    1.0.0
	 * @param    string   $order_id   Current order id.
	 * @return   mixed   
	 */
		public function process_payment( $order_id ) 
		{

		$start_log = sprintf( __( 'Payment process log for order ID: %s', 'wc-compralo' ), $order_id );
		Wc_Compralo_Logger::log( $start_log );
		
		$order = wc_get_order( $order_id );
		$url   = $order->get_meta( 'COMPLARO_PAYMENT_URL' );

		// Check if an order payment URL exists. 
		if ( filter_var( $url, FILTER_VALIDATE_URL ) ) :

			// Log register.
			$url_log = sprintf( __( 'Payment URL retrieved: %s', 'wc-compralo' ), $url );
			Wc_Compralo_Logger::log( $url_log );

			// Redirect for Complaro Gateway.
			return [ 
				'result'   => 'success', 
				'redirect' =>  $url 
			];

		// Creates an order payment URL.
		else :			

			// Get payment parameters.
			$store_name   = get_bloginfo( 'get_bloginfo' );
			$value        = $order->get_total();
			$postback_url = WC()->api_request_url( $this->id );
			$description  = sprintf( __( 'Order ID: %s', 'wc-compralo'), $order_id );
			$back_url     = $order->get_checkout_order_received_url();
			
			// Log register.
			$data_request = compact( 'store_name', 'value', 'postback_url', 'description', 'back_url' );
			Wc_Compralo_Logger::log( sprintf( __( 'Data send in HTTP Request:\r\n %s', 
				'wc-compralo' ), var_export( $data_request, TRUE ) ) );

			// Log register.
			$payment_request = $this->api->create( $store_name, $value, $postback_url, $description, $back_url );
			Wc_Compralo_Logger::log( sprintf( __( 'HTTP response received:\r\n %s', 
				'wc-compralo' ), var_export( $payment_request, TRUE ) ) );

			if( isset( $payment_request['status'] ) && TRUE == $payment_request['status'] ) :

				$compralo_url   = $payment_request['checkout_url'];
				$compralo_token = $payment_request['token'];

				// Add payment URL and token in order.
				$order->add_meta_data( 'COMPLARO_PAYMENT_URL', $compralo_url, TRUE );
				$order->add_meta_data( 'COMPLARO_PAYMENT_TOKEN', $compralo_token, TRUE );

				WC()->cart->empty_cart();

				/*
				// Orders updated as "on-hold" have automatic inventory reduction.
				$order->add_order_note( 
					__( 'The gateway will reduce inventory after payment is completed.', 'wc-compralo' ) );

				*/

				$order->update_status( 'on-hold', __( 'The buyer initiated the transaction, but so far Complaro has not received any payment information.', 'wc-compralo' ) );

				$order->save();

				// Redirect for URL payment.
				return [ 
					'result'   => 'success', 
					'redirect' =>  $compralo_url 
				];	

			else :

				wc_add_notice(  
					__( 'It looks like Compralo is down. Choose another payment method or try again!', 'wc-compralo' ), 'error' );

				return [
					'result' => 'fail'
				];
				
			endif;

		endif;


		}

	/**
	 * Notification request. Callback API for status changes.
	 *
	 * @access   public
	 * @since    1.0.0
	 * @return   void
	 */
		public function webhook() 
		{

		@ob_clean();

		// Log register.
		$all_headers                 = $_SERVER;
		$all_headers['CONTENT_BODY'] = file_get_contents( 'php://input' );
		
		Wc_Compralo_Logger::log( sprintf( __( 'Postback Headers:\r\n %s', 
			'wc-compralo' ), var_export( $all_headers, TRUE ) ) );
		
		$content_body = json_decode( $all_headers['CONTENT_BODY'], TRUE );
			
		if( json_last_error() == JSON_ERROR_NONE ) :
		
			if( isset($content_body['token']) && (isset( $content_body['status'] ) || isset( $content_body['status_id'] ) ) ) :
			
				$postback_token  = $content_body['token'];
				$postback_status = isset($content_body['status']) ? $content_body['status'] : $content_body['status_id'];
			
			endif;
		
		endif;
		
		if( isset( $_REQUEST['token'] ) && (isset( $_REQUEST['status'] ) || isset( $_REQUEST['status_id'] ) ) ) :
		
			$postback_token  = $_REQUEST['token'];
			$postback_status = isset($_REQUEST['status']) ? $_REQUEST['status'] : $_REQUEST['status_id'];
		
		endif;
		
		if( isset( $postback_token ) && isset( $postback_status ) ) :

			// Log register.
			$start_log = __( 'Compralo Gateway received a valid notification URL', 
				'wc-compralo' );
			Wc_Compralo_Logger::log( $start_log );

			// Get all order data with base token value.
			$query = array( 
				'meta_key'     => 'COMPLARO_PAYMENT_TOKEN', 
				'meta_compare' => '==', 
				'meta_value'   => $postback_token 
			);

			if( isset( wc_get_orders( $query )[0] ) ) :
			
				$order        = wc_get_orders( $query )[0];
				$order_id     = $order->get_order_number();
				$order_status = $order->get_status();

				switch ( $postback_status ) {
				    
				    case '1':
				    	
				    	if ( 'pending' == $order_status 
				    		|| 'on-hold' == $order_status 
				    		|| 'created' == $order_status 
				    		|| 'cancelled' == $order_status ) :

				    		// Reduce stock.
				        	wc_reduce_stock_levels( $order_id );

				        	// Sets order notes.
				        	$order->add_order_note( __( 'A status update has been received. The new order status is: processing' ) );
				        	$order->add_order_note( __( 'Inventory levels have been reduced' ) );

				        	// Update order status.
				        	$order->update_status('processing', __( 'Payment completed', 'wc-compralo' ));

				    	endif;

				    break;

				}

			endif;

		endif;

		exit;

		}
		
	/**
	 * Check the requirements for run the gateway in checkout	
	 *
	 * @access   public
	 * @since    1.0.0
	 * @return   boolean 
	 */
		public function is_available()
		{

		if ( ! empty( $this->api_key ) && $this->enabled ) :
		
			return TRUE;

		endif;

		return FALSE;

		}

	/**
	 * Include dependencies for payment method	
	 *
	 * @access   public
	 * @since    1.0.0
	 * @return   void
	 */
		public function require() 
		{

		require_once( 'includes/functions.php' );

		}

	/**
	 * Init hooks.
	 *
	 * @access   public
	 * @since    1.0.0
	 * @return   void
	 */
		public function init_hooks() 
		{

		// Initial hook for add scripts and styles for payment method.
		add_action( 'admin_enqueue_scripts', 'wc_compralo_method_redirect_admin_enqueue' );
		add_action( 'wp_enqueue_scripts', 'wc_compralo_method_redirect_public_enqueue' );

		// Initial hook for payment method logic.
		add_action( 'woocommerce_api_' . $this->id, array( $this, 'webhook' ) );
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		
		}

	}

}