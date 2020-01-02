<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Wc_Compralo' ) ) {

/**
 * The core plugin class.
 *
 * @link       https://github.com/compralo/woocommerce-plugin
 * @since      1.0.0
 *
 * @package    wc-compralo
 * @subpackage wc-compralo/includes/
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 */
	final class Wc_Compralo {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
		private $_plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of the plugin.
	 */
		private $_version;
		
	/**
	 * The web URL to the plugin directory.
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 * @var      string      The URL path for assets files
	 */
		private $_plugin_url;

	/**
	 * The server path to the plugin directory.
	 *
	 * @since    1.0.0
	 * @access   private
	 *
	 * @var      string      The plugin folder absolute path
	 */
		private $_plugin_path;

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
			SELF::$_instance->init_globals();
			SELF::$_instance->init_actions();
		
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
	 * Setup the class globals.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @codeCoverageIgnore
	 */
		public function init_globals() 
		{
		
		$this->_plugin_name  =  WC_COMPRALO_NAME;
		$this->_version      =  WC_COMPRALO_VERSION;
		$this->_plugin_url   =  WC_COMPRALO_URI;
		$this->_plugin_path  =  WC_COMPRALO_PATH;
		
		}

	/**
	 * Setup the hooks, actions and filters.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
		private function init_actions() 
		{

		
		}

	/**
	 * The name of the plugin used to uniquely identify it within the context
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
		public function get_plugin_name() 
		{
		
		return $this->_plugin_name;
		
		}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
		public function get_version() 
		{
		
		return $this->_version;
		
		}
		
	/**
	 * Retrieve the web url of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The url of the plugin.
	 */
		public function get_plugin_url() 
		{
		
		return $this->_plugin_url;
		
		}
		
	/**
	 * Retrieve the absolute path of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The absolute path of the plugin.
	 */
		public function get_plugin_path() 
		{
		
		return $this->_plugin_url;
		
		}
		
	/**
	 * The gateway API.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
		public function api() 
		{

		return Wc_Compralo_Api::instance();
		
		}

	/**
	 * The environment data.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
		public function environment() 
		{

		return Wc_Compralo_Environment::instance();
		
		}

	/**
	 * The environment data.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
		public function telemetry() 
		{

		return Wc_Compralo_Telemetry::instance();
		
		}

	}

}
