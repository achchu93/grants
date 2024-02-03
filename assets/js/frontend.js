( function( $ ) {

	var filters = {};

	/**
	 * Add filter element as a chip.
	 *
	 * @param {string} key
	 * @param {string} label
	 */
	function addFilterToList( key, label ) {
		$( '.grant-filter-list' ).prepend( '<div class="grant-filter-list--item" data-key="'+ key +'"><button></button>'+ label +'</div>' );
	}

	/**
	 * Remove filter element from the chip list.
	 *
	 * @param {string} key
	 */
	function removeFilterFromList( key ) {
		$( '.grant-filter-list--item[data-key="'+key+'"]' ).remove();
	}

	/**
	 * Remove selected filter value from the dropdown.
	 *
	 * @param {string} key
	 */
	function removeSelectedFilterValue( key ) {
		$( '.grant-custom-dropdown--trigger[data-filter="'+key+'"]' ).next().find( '.is-active' ).removeClass( 'is-active' );
	}

	/**
	 * Clear all filters.
	 */
	function clearFilters() {
		$( '.grant-filter-list--item' ).remove();
		$( '.grant-custom-dropdown--list-item.is-active' ).removeClass( 'is-active' );
	}

	/**
	 * On document ready.
	 */
	$( function() {

		// Filter dropdown interaction.
		$( '.grant-custom-dropdown' ).on( 'click', '.grant-custom-dropdown--trigger', function( e ) {
			e.preventDefault();

			var dropdown = $( this ).closest( '.grant-custom-dropdown' );
			$( '.grant-custom-dropdown' ).not( dropdown ).removeClass( 'is-open' );
			dropdown.toggleClass( 'is-open' );
		} );

		// Filter dropdown list item interaction.
		$( '.grant-custom-dropdown--list-item' ).on( 'click', function( e ) {

			var filter = $( this ).parent().prev().data( 'filter' );
			var value = $( this ).data( 'value' );
			var label = $( this ).text();

			if ( filter && value ) {

				filters[filter] = value;

				$( this ).addClass( 'is-active' ).siblings().removeClass( 'is-active' );

				removeFilterFromList( filter );
				addFilterToList( filter, label );
			}
		} );

		// Handle filter chip remove.
		$( '.grant-filter-list' ).on( 'click', '.grant-filter-list--item button', function( e ) {
			e.preventDefault();

			var key = $( this ).parent().data( 'key' );
			delete filters[key];

			removeFilterFromList( key );
			removeSelectedFilterValue( key );
		} );


		// Handle clear filter button.
		$( '#clear-filter' ).on( 'click', function() {
			filters = {};
			clearFilters();
		} );

	} );

} )( window.jQuery );
