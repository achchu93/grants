<?php

namespace Grants\Shortcodes;


class Grant_Filter {
	/**
	 * Initializes the shortcode.
	 */
	public function init() {
		add_shortcode( 'grant_filter', [ $this, 'render' ] );
		add_action( 'wp_footer', [ $this, 'render_modal' ] );
	}

	/**
	 * Renders the shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 */
	public function render( $atts ) {
		ob_start();
		include GRANTS_PLUGIN_DIR . '/views/frontend/grant/filter.php';
		return ob_get_clean();
	}

	/**
	 * Renders the modal.
	 */
	public function render_modal() {
		ob_start();
		include GRANTS_PLUGIN_DIR . '/views/frontend/grant/filter-modal.php';
		echo ob_get_clean();
	}
}
