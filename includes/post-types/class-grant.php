<?php

namespace Grants\PostTypes;

/**
 * Grant post type.
 */
class Grant {
	/**
	 * Post type name.
	 */
	private $post_type = 'past-grants';

	/**
	 * Initializes the post type.
	 */
	public function init() {
		add_filter( "manage_{$this->post_type}_posts_columns", [ $this, 'add_custom_columns' ] );
		add_action( "manage_{$this->post_type}_posts_custom_column", [ $this, 'render_custom_columns' ], 10, 2 );
		add_filter( "rest_{$this->post_type}_query", [ $this, 'modify_query' ], 99, 2 );
	}

	/**
	 * Setup custom columns.
	 */
	public function add_custom_columns( $columns ) {

		unset( $columns['date'] );

		$columns['recipient']     = 'Recipient';
		$columns['project_title'] = 'Project Title';
		$columns['program']       = 'Program';
		$columns['location']      = 'Location';
		$columns['amount']        = 'Amount';
		$columns['grant_date']    = 'Date';

		return $columns;
	}

	/**
	 * Render custom columns.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 */
	public function render_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'recipient':
				echo esc_html( get_post_meta( $post_id, 'recipient', true ) );
				break;
			case 'project_title':
				echo esc_html( get_post_meta( $post_id, 'project-title', true ) );
				break;
			case 'program':
				echo esc_html( get_post_meta( $post_id, 'grant-program', true ) );
				break;
			case 'location':
				echo esc_html( get_post_meta( $post_id, 'location', true ) );
				break;
			case 'amount':
				echo esc_html( get_post_meta( $post_id, 'amount', true ) );
				break;
			case 'grant_date':
				echo date( 'Y-m-d', strtotime( get_post_meta( $post_id, 'date', true ) ) );
				break;
		}
	}

	/**
	 * Modify the query for the grant post type.
	 */
	public function modify_query( $args, $request ) {

		if ( isset( $request['filter'] ) ) {

			if ( isset( $request['filter']['meta'] ) ) {
				$metas      = is_array( $request['filter']['meta'] ) ? $request['filter']['meta'] : [];
				$meta_query = [];

				foreach ( $metas as $meta ) {
					$meta_query[] = [
						'key'     => $meta['key'],
						'value'   => $meta['value'],
						'compare' => isset( $meta['compare'] ) ? $meta['compare'] : '=',
						'type'    => isset( $meta['type'] ) ? $meta['type'] : 'CHAR'
					];
				}

				if ( count( $meta_query ) ) {
					$meta_query['relation'] = 'AND';
					$args['meta_query']     = $meta_query;
				}
			}

			if ( isset( $request[ 'filter' ][ 'meta_key' ] ) ) {
				$args['meta_key'] = $request[ 'filter' ][ 'meta_key' ];
			}

			if ( isset( $request[ 'filter' ][ 'meta_type' ] ) ) {
				$args['meta_type'] = $request[ 'filter' ][ 'meta_type' ];
			}

			if ( isset( $request[ 'filter' ][ 'order' ] ) ) {
				$args['order'] = $request[ 'filter' ][ 'order' ];
			}

			if ( isset( $request[ 'filter' ][ 'orderby' ] ) ) {
				$args['orderby'] = $request[ 'filter' ][ 'orderby' ];
			}
		}

		if ( ! empty( $args['s'] ) ) {
			$args = $this->get_search_args( $args );
		}

		return $args;
	}

	/**
	 * Get search query setup.
	 * 
	 * @param array $args Query arguments.
	 * @return array
	 */
	private function get_search_args( $args ) {

		$searchable_fields = [ 'recipient', 'project-title', 'grant-program', 'location' ];
		$meta_keys         = ! empty( $args['meta_query'] ) ? wp_list_pluck( $args['meta_query'], 'key' ) : [];
		$fields_to_search  = array_diff( $searchable_fields, $meta_keys );
		$search_meta_query = [];

		foreach ( $fields_to_search as $field ) {
			$search_meta_query[] = [
				'key'     => $field,
				'value'   => $args['s'],
				'compare' => 'LIKE'
			];
		}

		if ( count( $search_meta_query ) ) {
			$search_meta_query['relation']  = 'OR';
			$args['meta_query']['relation'] = 'OR';

			array_unshift( $args['meta_query'], $search_meta_query );

			// unset search term to prevent default search by post table columns
			$args['s'] = '';
		}

		return $args;
	}
}
