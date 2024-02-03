<?php

namespace Grants\Shortcodes;


class Grant_Listing {
	/**
	 * Initializes the shortcode.
	 */
	public function init() {
		add_shortcode( 'grant_listing', [ $this, 'render' ] );
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
				'post_type'      => 'grant',
				'posts_per_page' => $atts['limit'],
			]
		);

		ob_start();
		include GRANTS_PLUGIN_DIR . '/views/frontend/grant/list.php';
		wp_reset_postdata();
		return ob_get_clean();
	}
}
