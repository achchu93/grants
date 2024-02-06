<?php

namespace Grants\PostTypes;

/**
 * Grant post type.
 */
class Grant {
	/**
	 * Post type name.
	 */
	private $post_type = 'grant';

	/**
	 * Post type labels.
	 */
	private $labels = [
		'name'               => 'Grants',
		'singular_name'      => 'Grant',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Grant',
		'edit_item'          => 'Edit Grant',
		'new_item'           => 'New Grant',
		'all_items'          => 'All Grants',
		'view_item'          => 'View Grant',
		'search_items'       => 'Search Grants',
		'not_found'          => 'No Grants found',
		'not_found_in_trash' => 'No Grants found in Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Grants',
	];

	/**
	 * Initializes the post type.
	 */
	public function init() {
		add_action( 'init', [ $this, 'register_post_type' ] );
		add_action( 'init', [ $this, 'register_post_meta' ] );
		add_action( 'add_meta_boxes', [ $this, 'add_metabox_fieds' ] );
		add_action( 'save_post', [ $this, 'save_metabox_fields' ] );
		add_filter( 'manage_grant_posts_columns', [ $this, 'add_custom_columns' ] );
		add_action( 'manage_grant_posts_custom_column', [ $this, 'render_custom_columns' ], 10, 2 );
		add_filter( 'rest_grant_query', [ $this, 'modify_query' ], 99, 2 );
	}

	/**
	 * Registers the post type.
	 */
	public function register_post_type() {
		register_post_type(
			$this->post_type,
			[
				'labels'             => $this->labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'menu_icon'          => 'dashicons-money-alt',
				'supports'           => [ 'title', 'editor', 'custom-fields' ],
				'query_var'          => true,
				'rewrite'            => [ 'slug' => 'grant' ],
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'show_in_rest'       => true
			]
		);
	}

	/**
	 * Registers post meta fields.
	 */
	public function register_post_meta() {
		$meta_fields = [
			'grant_recipient' => [
				'type'  => 'string',
			],
			'grant_project_title' => [
				'type'  => 'string',
			],
			'grant_program' => [
				'type' => 'string',
			],
			'grant_location' => [
				'type' => 'string',
			],
			'grant_date' => [
				'type' => 'string',
			],
			'grant_amount' => [
				'type' => 'string',
			],
		];

		foreach ( $meta_fields as $key => $args ) {
			register_post_meta(
				$this->post_type,
				$key,
				array_merge(
					$args,
					[
						'show_in_rest' => true,
						'single'       => true,
					]
				)
			);
		}
	}

	/**
	 * Setup metabox fields.
	 */
	public function add_metabox_fieds() {
		add_meta_box(
			'grant_information',
			'Grant Information',
			[ $this, 'metabox_view' ],
			'grant'
		);
	}

	/**
	 * Setup metabox view.
	 *
	 * @param WP_Post $post Post object.
	 */
	public function metabox_view( $post ) {
		include GRANTS_PLUGIN_DIR . '/views/admin/metabox.php';
	}

	/**
	 * Save metabox fields.
	 *
	 * @param int $post_id Post ID.
	 */
	public function save_metabox_fields( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_REQUEST['grant_nonce'], 'grant-save-information' ) ) {
			return;
		}

		$meta_fields = [
			'grant_recipient',
			'grant_project_title',
			'grant_program',
			'grant_location',
			'grant_date',
			'grant_amount',
		];

		foreach ( $meta_fields as $field ) {
			if ( array_key_exists( $field, $_POST ) ) {
				update_post_meta(
					$post_id,
					$field,
					$_POST[ $field ]
				);
			}
		}
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
				echo esc_html( get_post_meta( $post_id, 'grant_recipient', true ) );
				break;
			case 'project_title':
				echo esc_html( get_post_meta( $post_id, 'grant_project_title', true ) );
				break;
			case 'program':
				echo esc_html( get_post_meta( $post_id, 'grant_program', true ) );
				break;
			case 'location':
				echo esc_html( get_post_meta( $post_id, 'grant_location', true ) );
				break;
			case 'amount':
				echo esc_html( get_post_meta( $post_id, 'grant_amount', true ) );
				break;
			case 'grant_date':
				echo date( 'Y-m-d', strtotime( get_post_meta( $post_id, 'grant_date', true ) ) );
				break;
		}
	}

	/**
	 * Modify the query for the grant post type.
	 */
	public function modify_query( $args, $request ) {

		if ( isset( $request['filter'] ) && isset( $request['filter']['meta'] ) ) {
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

		return $args;
	}
}
