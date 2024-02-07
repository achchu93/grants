<?php

namespace Grants\Shortcodes;


class Grant_Listing {
	/**
	 * Initializes the shortcode.
	 */
	public function init() {
		add_shortcode( 'grant_listing', [ $this, 'render' ] );
		add_action( 'wp_footer', [ $this, 'underscore_template' ] );
	}

	/**
	 * Renders the shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 */
	public function render( $atts ) {
		$atts = shortcode_atts(
			[
				'limit' => 10,
			],
			$atts
		);

		$query = new \WP_Query(
			[
				'post_type'      => 'past-grants',
				'posts_per_page' => $atts['limit'],
				'orderby'        => 'meta_value',
				'order'          => 'DESC',
				'meta_key'       => 'date',
				'meta_type'      => 'DATE',
			]
		);

		ob_start();
		include GRANTS_PLUGIN_DIR . '/views/frontend/grant/list.php';
		wp_reset_postdata();
		return ob_get_clean();
	}

	/**
	 * Underscore template for list item.
	 */
	public function underscore_template() {
		include_once GRANTS_PLUGIN_DIR . '/views/frontend/grant/temp-list-item.php';
	}
}
