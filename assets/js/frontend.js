( function( $ ) {

	$( function() {

		$( '.grant-custom-dropdown' ).on( 'click', '.grant-custom-dropdown--trigger', function( e ) {
			e.preventDefault();

			var dropdown = $( this ).closest( '.grant-custom-dropdown' );

			$( '.grant-custom-dropdown' ).not( dropdown ).removeClass( 'is-open' );
			dropdown.toggleClass( 'is-open' );
		} );

	} );

} )( window.jQuery );
