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
				'supports'           => [ 'title', 'editor' ],
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
}
