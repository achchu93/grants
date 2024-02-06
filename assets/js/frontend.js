( function( $ ) {

	var $container = $( '.grant-list-content' );
	var filters = {};
	var oldFilters = {};
	var Grant = null;
	var currentRequest = null;

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
		$( '#grant_search' ).val( '' );
	}


	/**
	 *
	 * @param {number} limit
	 * @returns {Promise}
	 */
	function fetchGrants( limit ) {

		if ( currentRequest !== null ) {
			currentRequest.abort();
		}

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

		var data = { per_page: limit, filter: Object.assign( appliedFilters, getSortFilter() ) };
		var searchTerm = $( '#grant_search' ).val().trim();

		if ( searchTerm.length ) {
			data['search'] = searchTerm;
		}

		oldFilters = Object.assign( {}, filters );
		currentRequest = Grant.fetch( { data: data } );

		return currentRequest;
	}

	function getSortFilter() {
		var sortSelected = $( '.grant-custom-dropdown--trigger[data-filter="sortby"]' ).next().find( '.is-active' ).data( 'value' );
		var sortFilter = {
			'orderby': sortSelected === 'title' ? 'title' : 'meta_value',
			'order': sortSelected === 'title' ? 'ASC' : 'DESC'
		};

		if ( sortSelected !== 'title' ) {
			sortFilter['meta_key'] = 'grant_date';
			sortFilter['meta_type'] = 'DATE';
		}

		return sortFilter;
	}

	function appendItemsToList( data ) {
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

	function loadList( limit, cb, pages ) {

		Grant = new wp.api.collections.Grant();

		if ( ! limit ) {
			limit = 10;
		}

		$container.html( '' );

		( function processList( hasMore, callback ) {
			if ( hasMore ) {
				fetchGrants( limit )
					.then( function( response ) {
						appendItemsToList( response );
						processList( pages !== undefined ? ( pages > Grant.state.currentPage ) : Grant.hasMore() , callback );
					} );
			} else {
				callback();
			}
		} )( true, function() {
			if ( undefined !== cb ) cb();
		} );
	}

	function search( e )  {
		var term = $( this ).val().trim();

		if ( ! term.length ) {
			return;
		}

		Grant = null;

		applyFilters();
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
					loadList(
						10,
						undefined,
						Grant.state.currentPage
					);
					return;
				}

				if ( filter === 'date' && value === 'custom' ) {
					$( '#from' ).trigger( 'change' );
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

			loadList(
				2,
				function() {
					self.attr( 'disabled', false );
				}
			);
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


		$( '#grant_search' ).on( 'keyup', _.debounce( search , 500 ) );

		$( '#from, #to' ).on( 'change', function() {
			var from = $( '#from' ).val();
			var to = $( '#to' ).val();

			var reg = /^\d{4}$/;

			if ( ! from.toString().match( reg ) || ! to.toString().match( reg ) || from > to ) {
				console.log( 'invalid date range', from.toString().match( reg ), to.toString().match( reg ) );
				return;
			}

			var filterLabel = 'date';
			var filterValue = from + ' - ' + to;

			filters[ filterLabel ] = filterValue;

			removeFilterFromList( filterLabel );
			addFilterToList( filterLabel, filterValue );
			applyFilters();
		} );


	} );

} )( window.jQuery );
