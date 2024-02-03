( function( $ ) {

	var filters = {};

	function addFilterToList( key, label ) {
		$( '.grant-filter-list' ).prepend( '<div class="grant-filter-list--item" data-key="'+ key +'"><button></button>'+ label +'</div>' );
	}

	function removeFilterFromList( key ) {
		$( '.grant-filter-list--item[data-key="'+key+'"]' ).remove();
	}

	function applyFilters() {
		Object.entries( filters ).forEach( function( [ key, value ] ) {
			var label = $( '.grant-custom-dropdown--list-item[data-value="' + value + '"]' ).text();
			removeFilterFromList( key );
			addFilterToList( key, label );
		} );
	}

	$( function() {

		$( '.grant-custom-dropdown' ).on( 'click', '.grant-custom-dropdown--trigger', function( e ) {
			e.preventDefault();

			var dropdown = $( this ).closest( '.grant-custom-dropdown' );

			$( '.grant-custom-dropdown' ).not( dropdown ).removeClass( 'is-open' );
			dropdown.toggleClass( 'is-open' );
		} );

		$( '.grant-custom-dropdown--list-item' ).on( 'click', function( e ) {

			var filter = $( this ).parent().prev().data( 'filter' );
			var value = $( this ).data( 'value' );

			if ( filter && value ) {

				$( this )
					.addClass( 'is-active' )
					.siblings().removeClass( 'is-active' );

				filters[filter] = value;

				applyFilters();
			}
		} );

		$( '.grant-filter-list' ).on( 'click', '.grant-filter-list--item button', function( e ) {
			e.preventDefault();

			var key = $( this ).parent().data( 'key' );
			removeFilterFromList( key );
			delete filters[key];
			applyFilters();
		} );


		$( '#clear-filter' ).on( 'click', function() {
			$( '.grant-filter-list--item' ).remove();
			filters = {};
		} )

	} );

} )( window.jQuery );
