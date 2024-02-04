<?php

namespace Grants\Utils;

class Price {

	/**
	 * Get ranges from min to max.
	 *
	 * @param int|float $min
	 * @param int|float $max
	 * @return array
	 */
	public static function ranges( $min, $max ) {
		$ranges = [];

		if ( $min > $max ) {
			$temp = $min;
			$min = $max;
			$max = $temp;
		} else if ( $min === $max ) {
			return [ 0, $max ];
		}

		$avg  = $max / 6;
		$last = 0;

		for ( $i = 1; $i <= 6; $i++ ) {
			$value    = $avg * $i;
			$power    = $value < 100 ? 10: 100;
			$amount   = floor( $value / $power ) * $power;

			if ( $i === 1 ) {
				if ( $amount < $min ) {
					$amount   = $min;
					$ranges[ $amount ] = self::price( $amount );
				} else {
					$ranges[ '<' . $amount ] = '&#60; ' . self::price( $amount );
				}
				$last = $amount;
				continue;
			}

			$from           = $last + 1;
			$key            = sprintf( '%s-%s', $from, $amount );
			$ranges[ $key ] = sprintf( '%s - %s', self::price( $from ), self::price( $amount ) );
			$last           = $amount;
		}

		return $ranges;
	}


	/**
	 * Get price formatted.
	 *
	 * @param int|float $amount
	 * @return string
	 */
	public static function price( $amount ) {
		return '&#36;' . number_format( $amount );
	}
}
