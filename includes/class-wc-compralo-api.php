<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Wc_Compralo_Api' ) ) {

/**
 * The plugin class for API integration.
 */

	class Wc_Compralo_Api {
		
	/**
	 * The API key integration.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $_api_key
	 */
		private $_api_key;
		
	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of the plugin.
	 */
		private static $_instance = NULL;
		
	/**
	 * Main WC_Payment_Gateways Instance.
	 *
	 * Ensures only one instance of WC_Payment_Gateways is loaded or can be loaded.
	 *
	 * @since 2.1
	 * @return WC_Payment_Gateways Main instance
	 */
		public static function instance() 
		{
		
		if ( is_null( SELF::$_instance ) ) : 

			SELF::$_instance = new SELF();
		
		endif;
		
		return SELF::$_instance;
		
		}
		
	/**
	 * A dummy constructor to prevent this class from being loaded more than once.
	 *
	 * @since    1.0.0
	 */
		private function __construct() 
		{
		
		}
		
	/**
	 * You cannot clone this class.
	 *
	 * @since    1.0.0
	 * @codeCoverageIgnore
	 */
		public function __clone() 
		{

		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wc-compralo' ), '1.0.0' );
		
		}

	/**
	 * You cannot unserialize instances of this class.
	 *
	 * @since    1.0.0
	 * @codeCoverageIgnore
	 */
		public function __wakeup() 
		{
		
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wc-compralo' ), '1.0.0' );
		
		}
		
	/**
	 * Sets API Key
	 *
	 * @access    public
	 * @since     1.0.0
	 * @param     string     The compralo API Key.
	 * @return    void
	 */
		public function set_api_key( $api_key ) 
		{
		
		$this->_api_key = $api_key;
		
		}

	/**
	 * Gets API Key
	 *
	 * @access    public
	 * @since     1.0.0
	 * @return    string     The compralo API Key.
	 */
		public function get_api_key() 
		{
		
		return $this->_api_key;
		
		}

		  public function create($store_name, $value, $postback_url, $description, $back_url=null){

		  $data = json_encode([
			  'api_key' => $this->_api_key,
			  'value' => $value,
			  'store_name' => $store_name,
			  'postback_url' => $postback_url,
			  'description' => $description,
			  'back_url' => $back_url,
		  ]);

		  $curl = curl_init();

		  curl_setopt_array($curl, array(
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_URL => "https://app.compralo.io/api/v1/seller/generateInvoice",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
			  "Content-Type: application/json"
			),
		  ));
		  $response = curl_exec($curl);
		  $err = curl_error($curl);
		  curl_close($curl);
		  if ($err) {
			return "cURL Error #:" . $err;
		  } else {
			  $response_data = json_decode( $response, TRUE );
			  return $response_data;
		  }
		}
		public function check($checkout_token){
		  $curl = curl_init();
		  curl_setopt_array($curl, array(
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_URL => "https://app.compralo.io/api/v1/seller/checkStatus/".$checkout_token,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			  "Content-Type: application/json"
			),
		  ));
		  $response = curl_exec($curl);
		  $err = curl_error($curl);
		  curl_close($curl);
		  if ($err) {
			return "cURL Error #:" . $err;
		  } else {
			  $status_data = json_decode($response);
			  if($status_data->status == 1){
				return 'complete';
			  }elseif($status_data->status == 3){
				return 'expired';
			  }
			  return 'pending';
		  }
		}
	}
}