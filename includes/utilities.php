<?php
/**
 * Utility functions
 */

/**
 * Utility function for retrieving and caching
 * JSON feeds
 * @author Jim Barnes
 * @since 1.0.0
 * @param string $url The url of the API to retrieve JSON from
 * @param string $transient_prefix The prefix to prepend to the transient name.
 * @param int $transient_ttl The number of hours to cache the transient
 * @return object|array The json array
 */
function research_fetch_cache_json( $url, $transient_prefix = 'research_', $transient_ttl = 24 ) {
	$transient_name = $transient_prefix . md5( $url );

	if ( $retval = get_transient( $transient_name ) ) {
		return $retval;
	} else {
		$response = wp_remote_get( $url, array( 'timeout' => 15 ) );

		if ( is_array( $response ) ) {
			$retval = json_decode( wp_remote_retrieve_body( $response ) );
		} else {
			$retval = false;
		}

		if ( $retval ) {
			set_transient( $transient_name, $retval, $transient_ttl * HOUR_IN_SECONDS );
		}
	}

	return $retval;
}
