( function( $ ) {

	var $container = $( '.grant-list-content' );
	var filters = {};
	var oldFilters = {};
	var Grant = null;

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
		filters = {};
		$( '.grant-filter-list--item' ).remove();
		$( '.grant-custom-dropdown--list-item.is-active' ).removeClass( 'is-active' );
	}


	/**
	 *
	 * @param {number} limit
	 * @returns {Promise}
	 */
	function fetchGrants( limit ) {

		if ( Grant && Grant.hasMore() && _.isEqual( oldFilters, filters ) ) {
			return Grant.more();
		}

		if ( ! Grant ) {
			Grant = new wp.api.collections.Grant();
		}

		var appliedFilters = {};

		appliedFilters['meta'] = Object.entries( filters ).map( function( [ filter, value ] ) {
			var compare = '=';
			value = value.toString();
			var type = 'CHAR';

			if ( value.indexOf( '<' ) !== -1 ) {
				value = value.replace( '<', '' ).trim();
				compare = '<=';
				type = 'NUMERIC';
			} else if ( value.indexOf( '-' ) !== -1 ) {
				value = value.replace( ' ', '' ).split( '-' );
				compare = 'BETWEEN';
				type = 'NUMERIC';
			} else if ( filter === 'date' ) {
				value = '^' + value + '-[0-9]{2}-[0-9]{2}$'
				compare = 'REGEXP';
				type = 'DATE';
			}

			filter = filter !== 'sortby' ? 'grant_' + filter : filter;

			return { key: filter, value: value, compare: compare, type: type };
		} );

		oldFilters = Object.assign( {}, filters );

		return Grant.fetch( { data: { per_page: limit, filter: appliedFilters } } );
	}

	function toggleListContainer( list ) {
		var container = $( '.grant-list-content' );
		if ( list === '' ) {
			container.html( '' );
		} else {
			container.append( list );
		}
	}


	function appendItemsToList( data ) {

		// Sort the data if a sort filter is selected.
		var sortSelected = $( '.grant-custom-dropdown--trigger[data-filter="sortby"]' ).next().find( '.is-active' ).data( 'value' );
		if ( sortSelected ) {
			data = sortData( sortSelected );
		}

		var template = wp.template( 'grant-list-item' );
		var children = data.map( function( model ) {
			if ( ! ( model instanceof wp.api.models.Grant ) ) {
				model = new wp.api.models.Grant( model );
			}
			return template({
				title: model.get('title').rendered,
				location: model.getMeta('grant_location'),
				recipient: model.getMeta('grant_recipient'),
				url: model.get('link')
			});
		} );

		$container.append( children );
	}

	function showLoading() {
		console.log( 'loading' );
	}

	function hideLoading() {
		console.log( 'done' );
	}

	function applyFilters( append, cb ) {
		if ( ! append ) {
			$container.html( '' );
		}

		showLoading();

		fetchGrants( 10 )
			.then( appendItemsToList )
			.done( function() {
				if ( undefined !== cb ) {
					cb();
				}
				hideLoading();
			} );
	}

	function sortData( sortBy ) {
		var sorted = Grant.sortBy( function( model ) {
			var property = 'default';

			switch ( sortBy ) {
				case 'title':
					property = model.get( 'title' ).rendered;
					break;
				case 'date':
					property = -model.getMeta( 'grant_date' );
					break;
				default:
					property = model.cid;
			}

			return property;
		} );

		return sorted;
	}

	function init() {
		fetchGrants();
	}

	/**
	 * On document ready.
	 */
	$( function() {

		// Initialize the data.
		init();

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

				$( this ).addClass( 'is-active' ).siblings().removeClass( 'is-active' );

				if ( filter === 'sortby' ) {
					$container.html( '' );
					appendItemsToList();
					return;
				}

				filters[filter] = value;

				removeFilterFromList( filter );
				addFilterToList( filter, label );

				applyFilters();
			}
		} );

		// Handle filter chip remove.
		$( '.grant-filter-list' ).on( 'click', '.grant-filter-list--item button', function( e ) {
			e.preventDefault();

			var key = $( this ).parent().data( 'key' );
			delete filters[key];

			removeFilterFromList( key );
			removeSelectedFilterValue( key );

			applyFilters()
		} );


		// Handle clear filter button.
		$( '#clear-filter' ).on( 'click', function() {

			if ( Object.keys( filters ).length === 0 ) {
				return;
			}

			clearFilters();
			applyFilters();
		} );

		// Handle view full list button.
		$( '#grant-list-full-view' ).on( 'click', function() {
			$( this ).attr( 'disabled', true );

			var self = $( this );

			clearFilters();

			( function processList( hasMore, callback ) {
				if ( hasMore ) {
					fetchGrants( 100 )
						.then( function( response ) {
							$container.html( '' );
							appendItemsToList( response );
							processList( Grant.hasMore(), callback );
						} );
				} else {
					callback();
				}
			} )( true, function() {
				self.attr( 'disabled', false );
			} );
		} );

		$( '#grant-list-show-more' ).on( 'click', function() {
			if ( ! Grant || ! Grant.hasMore() ) {
				return;
			}

			var self = $( this );
			self.attr( 'disabled', true );

			applyFilters( true, function() {
				self.attr( 'disabled', false );
			} );

		} );


	} );

} )( window.jQuery );
