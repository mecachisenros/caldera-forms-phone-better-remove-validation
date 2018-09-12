window.addEventListener( 'load', function() {

	Caldera_Forms_Field_Config = ( function( parent ) {
		return function() {
			var original = parent.apply( this, arguments );

			// override phone better
			this.phone_better = function( field ) {

				var init = function() {
					var $field = jQuery( document.getElementById( field.id ) );
					$field.intlTelInput( field.options );

				};

				jQuery( document ).on( 'cf.pagenav cf.add cf.disable cf.modal', init );
				init();
			}

			return original;
		};
	} )( Caldera_Forms_Field_Config );

} );
