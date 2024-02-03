<?php

namespace Grants\Shortcodes;


class Grant_Filter {
	/**
	 * Initializes the shortcode.
	 */
	public function init() {
		add_shortcode( 'grant_filter', [ $this, 'render' ] );
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
}
