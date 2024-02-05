<?php
namespace Grants;

/**
 * Main plugin class.
 */
final class Grants {

	/**
	 * Initializes plugin actions.
	 */
	public function init() {
		$this->includes();
		$this->init_instances();
		$this->init_hooks();
	}

	/**
	 * Includes plugin files.
	 */
	public function includes() {
		require_once __DIR__ . '/post-types/class-grant.php';
		require_once __DIR__ . '/store/class-grant.php';
		require_once __DIR__ . '/utils/class-price.php';
		require_once __DIR__ . '/shortcodes/class-grant-listing.php';
		require_once __DIR__ . '/shortcodes/class-grant-filter.php';
	}

	/**
	 * Initializes plugin instances.
	 */
	public function init_instances() {
		$instances = [
			new PostTypes\Grant(),
			new Shortcodes\Grant_Listing(),
			new Shortcodes\Grant_Filter()
		];

		foreach ( $instances as $instance ) {
			$instance->init();
		}
	}

	/**
	 * Initializes plugin hooks.
	 */
	public function init_hooks() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_assets' ] );
	}

	/**
	 * Enqueues frontend scripts and styles.
	 */
	public function enqueue_frontend_assets() {
		wp_register_style( 'grant-frontend', GRANTS_PLUGIN_URL . 'assets/css/frontend.css' );
		wp_register_script( 'grant-frontend', GRANTS_PLUGIN_URL . 'assets/js/frontend.js', [ 'jquery', 'wp-api', 'wp-util' ], false, true );

		wp_enqueue_style( 'grant-frontend' );
		wp_enqueue_script( 'grant-frontend' );
	}
}
