jQuery(function( $ ) {
	'use strict';

	/**
	 * Checkbox ID.
	 */
	var wc_compralo_testmode_id = '#woocommerce_wc_compralo_redirect_testmode';

	/**
	 * Object to handle Cielo admin functions.
	 */
	var wc_compralo_admin = {
		isTestMode: function() {
			return $( wc_compralo_testmode_id ).is( ':checked' );
		},

		/**
		 * Initialize.
		 */
		init: function() {
			$( document.body ).on( 'change', wc_compralo_testmode_id, function() {
				var key_production = $( '#woocommerce_wc_compralo_redirect_key_production' ).parents( 'tr' ).eq( 0 ),
					key_sandbox = $( '#woocommerce_wc_compralo_redirect_key_sandbox' ).parents( 'tr' ).eq( 0 );

				if ( $( this ).is( ':checked' ) ) {
					key_sandbox.show();
					key_production.hide();
				} else {
					key_sandbox.hide();
					key_production.show();
				}
			} );

			$( wc_compralo_testmode_id ).change();
		}
	};

	wc_compralo_admin.init();

});