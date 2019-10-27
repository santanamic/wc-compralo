<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Wc_Compralo_Logger' ) ) {

/**
 * Log all things.
 *
 * @link       https://github.com/compralo/woocommerce-plugin
 * @since      1.0.0
 *
 * @package    wc-compralo
 * @subpackage wc-compralo/includes/api/
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 */
	class Wc_Compralo_Logger 
	{
		
		public static $logger;
		
		const WC_LOG_FILENAME = 'wc-compralo';
		
		/**
		 * Utilize WC logger class
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 */
		public static function log( $message, $start_time = null, $end_time = null ) 
		{
			
			if ( ! class_exists( 'WC_Logger' ) ) {
				return;
			}

			if ( apply_filters( 'wc_compralo_logging', true, $message ) ) 
			{

				if ( empty( self::$logger ) ) {
					
					if ( Wc_Compralo_Helper::is_wc_lt( '3.0' ) ) {
						self::$logger = new WC_Logger();
					} 

					else {
						self::$logger = wc_get_logger();
					}

				}

				$settings = get_option( 'woocommerce_wc_compralo_redirect_settings' );
				
				if ( empty( $settings ) || ( ! isset( $settings['debug'] ) || 'yes' !== $settings['debug'] ) ) 
				{
					
					return;
				
				}
				
				if ( ! is_null( $start_time ) ) {
					
					$formatted_start_time = date_i18n( get_option( 'date_format' ) . ' g:ia', $start_time );
					$end_time             = is_null( $end_time ) ? current_time( 'timestamp' ) : $end_time;
					$formatted_end_time   = date_i18n( get_option( 'date_format' ) . ' g:ia', $end_time );
					$elapsed_time         = round( abs( $end_time - $start_time ) / 60, 2 );
					$log_entry  = "\n" . '====' . WC_COMPRALO_NAME . ' Version: ' . WC_COMPRALO_VERSION . '====' . "\n";
					$log_entry .= '====Start Log ' . $formatted_start_time . '====' . "\n" . $message . "\n";
					$log_entry .= '====End Log ' . $formatted_end_time . ' (' . $elapsed_time . ')====' . "\n\n";
				
				} 

				else {
					
					$log_entry  = "\n" . '====' . WC_COMPRALO_NAME . ' Version: ' . WC_COMPRALO_VERSION . '====' . "\n";
					$log_entry .= '====Start Log====' . "\n" . $message . "\n" . '====End Log====' . "\n\n";
				
				}
				
				if ( Wc_Compralo_Helper::is_wc_lt( '3.0' ) ) {
					
					self::$logger->add( self::WC_LOG_FILENAME, $log_entry );
				
				} 

				else {
				
					self::$logger->debug( $log_entry, array( 'source' => self::WC_LOG_FILENAME ) );
				
				}
			}
		}
	}
}