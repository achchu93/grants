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
		$this->init_shortcodes();
	}

	/**
	 * Includes plugin files.
	 */
	public function includes() {
		require_once __DIR__ . '/post-types/class-grant.php';
		require_once __DIR__ . '/shortcodes/class-grant-listing.php';
	}

	/**
	 * Initializes plugin instances.
	 */
	public function init_instances() {
		$grant = new PostTypes\Grant();
		$grant->init();
	}

	public function init_shortcodes() {
		$grant_listing = new Shortcodes\Grant_Listing();
		$grant_listing->init();
	}
}
