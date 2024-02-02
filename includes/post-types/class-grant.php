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
}
