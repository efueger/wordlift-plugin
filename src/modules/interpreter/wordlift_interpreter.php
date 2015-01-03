<?php
require_once( 'wordlift_interpreter_constants.php' );

/**
 * The Interpreter module communicates with WLS component 
 * in order to retrieve meanings (entities and iptc classifications) for posts
 */

/**
 * Iptc tagging for wordpress posts 
 *
 * @param string $uri The current post ID.
 *
 * @return array responde obj
 */
function wl_get_meanings_for_post( $post_id ) {

	$post = get_post( $post_id );
	
	if ( null == $post || "post" != $post->post_type ) {
		return false;
	}
	
	// Prepare the request.
	$args = array(
		'method'  => 'GET',
		'headers' => array()
	);

	$api_uri = WL_INTERPRETER_API_ENDPOINT . "article";
	// Add uri in querystring
	// Tmp: I'm using the post slug just for test porpouse
	$post_identifier = $post->post_name;
	
	$api_uri = add_query_arg( 'url', urlencode( $post->post_name ), $api_uri );
	// Perform requests
	$response = wp_remote_request( $api_uri, $args );

	// Process only valid responses.
    if ( ! is_wp_error( $response ) && 200 === (int)$response['response']['code'] ) {
	
		wl_write_log( "wordlift interpreter: Going to retrieve meanings for post {$post_id} identified by {$post_identifier} " );
    	$response = json_decode( $response['body'], true );

		foreach ( $response['categories'] as $category ) {
			wl_write_log( "wordlift interpreter: Add {var_dump($category)} to post {$post_id}" );
    		// Save iptc classification
			wl_add_iptc_classification_to_post( $post_id, $category['label'], $category['code'] );  
		}

		foreach ( $response['topics'] as $entity ) {
			
			wl_write_log( "wordlift interpreter: Add {var_dump($category)} to post {$post_id}" );
			$entity_label = $entity['label'] . ' ('. $entity['id'] . ')';
			// Save entity on WP and Redlink
			wl_linked_data_save_entity( 
				'', $entity_label, $entity['type'], '', array( $entity['type'] ), array(), $post_id, array( $entity['itemId'] ) 
			);
		}
    } else {
    	wl_write_log( "wordlift interpreter: Error on retrieve meanings for post {$post_id} identified by {$post_identifier} " );
    	return false;
    }

	return true;
}

add_action( 'save_post', 'wl_get_meanings_for_post' );

