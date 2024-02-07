<?php

namespace Grants\Store;

class Grant {

	/**
	 * Post type.
	 */
	private static $post_type = 'past-grants';

	/**
	 * Cache prefix.
	 */
	private static $cache_prefix = 'grant_ob_cache_';

	/**
	 * Get all grants.
	 *
	 * @param int $limit
	 * @return array
	 */
	public static function get_all( $limit = 10 ) {

	}

	/**
	 * Get years.
	 *
	 * @return array
	 */
	public static function get_years() {
		return self::query_distinct_list( 'date', 'year' );
	}

	/**
	 * Get programs.
	 *
	 * @return array
	 */
	public static function get_programs() {
		return self::query_distinct_list( 'grant-program' );
	}

	/**
	 * Get amounts.
	 *
	 * @return array
	 */
	public static function get_amounts() {
		return self::query_distinct_list( 'amount' );
	}

	/**
	 * Query grants.
	 *
	 * @param array $args
	 * @return array
	 */
	public static function query( $args = [] ) {

	}

	/**
	 * Query distinct list by meta key.
	 *
	 * @param string $meta
	 * @param string $type
	 * @return array
	 */
	public static function query_distinct_list( $meta, $type = 'string' ) {
		global $wpdb;

		$cache_key = self::$cache_prefix . $meta;
		$data      = wp_cache_get( $cache_key );

		if ( false !== $data && is_array( $data ) ) {
			return $data;
		}

		$method = 'UCASE';

		switch ( $type ) {
			case 'year':
				$method = 'YEAR';
				break;
		}

		$prepared = $wpdb->prepare(
			"SELECT DISTINCT $method(meta_value) FROM {$wpdb->postmeta} WHERE meta_key = %s",
			esc_sql( $meta )
		);

		$data = $wpdb->get_col( $prepared );

		wp_cache_set( self::$cache_prefix . $meta, $data );

		return $data;
	}
}
