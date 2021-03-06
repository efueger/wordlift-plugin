<?php

/*
Plugin Name: WordLift Profiling
Plugin URI: http://wordlift.it
Description: Profiles remote SPARQL queries.
Version: 3.0.0-SNAPSHOT
Author: InsideOut10
Author URI: http://www.insideout.io
License: APL
*/

// The profiling custom post type.
define( 'WL_PROFILING_POST_TYPE', 'wl_profiling' );
define( 'WL_PROFILING_DURATION_META_KEY', 'wl_profiling_duration' );
define( 'WL_PROFILING_SPARQL_QUERY_META_KEY', 'wl_profiling_sparql_query' );

// Load the profiling custom post type.
require_once( 'wordlift_profiling_post_type.php' );

/**
 * Records the execution of a query.
 *
 * @since 3.0.0
 *
 * @param string $url   The remote URL.
 * @param string $args  The request parameters.
 * @param string $query The SPARQL query.
 */
function wl_profiling_sparql_pre_request( $url, $args, $query ) {

    global $wl_profiling_started_at;
    $wl_profiling_started_at = round(microtime(true) * 1000);

}
add_action( 'wl_sparql_pre_request', 'wl_profiling_sparql_pre_request', 10, 3 );

/**
 * Records the end of the execution of a query.
 *
 * @since 3.0.0
 *
 * @uses wl_caching_is_response_cached() to determine if the response is cached. Cached responses are ignored.
 *
 * @param string $url     The remote URL.
 * @param string $args    The request parameters.
 * @param string $query   The SPARQL query.
 * @param array $response The response.
 */
function wl_profiling_sparql_post_request( $url, $args, $query, $response ) {

    global $wl_profiling_started_at;

    // Ignore cached calls.
    if ( function_exists( 'wl_caching_response_is_cached' ) && wl_caching_response_is_cached( $response ) ) {
        return;
    }

    $interval = round(microtime(true) * 1000) - $wl_profiling_started_at;

	// Insert the profiling data.
	wl_profiling_insert( $query, $interval );

}
add_action( 'wl_sparql_post_request', 'wl_profiling_sparql_post_request', 10, 4 );
