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
	}

	/**
	 * Includes plugin files.
	 */
	public function includes() {
		require_once __DIR__ . '/post-types/class-grant.php';
	}

	/**
	 * Initializes plugin instances.
	 */
	public function init_instances() {
		$grant = new PostTypes\Grant();
		$grant->init();
	}
}
