<?php
require_once( 'wordlift_interpreter_constants.php' );

/**
 * The Interpreter module communicates with WLS component 
 * in order to retrieve meanings (entities and iptc classifications) for posts
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
	$post_identifier = $post->post_name;
	
	$api_uri = add_query_arg( 'url', urlencode( $post->post_name ), $api_uri );

	// Perform requests
	$response = wp_remote_request( $api_uri, $args );	
	// Process only valid responses.
    if ( ! is_wp_error( $response ) && 200 === (int)$response['response']['code'] ) {
		$response = ( "" == $response['body'] ) ? 
			array( 'topics' => array(), 'categoryMatches' => array() ) : 
			json_decode( $response['body'], true );
    } else {
    	$response = array( 'topics' => array(), 'categoryMatches' => array() );
    }

    return $response;
}


/**
 * Iptc tagging for wordpress posts 
 *
 * @param string $uri The current post ID.
 *
 * @return array responde obj
 */
function wl_set_meanings_for_post( $post_id, $meanings ) {

		wl_write_log( "wordlift interpreter: Going to retrieve meanings for post {$post_id} identified by {$post_identifier} " );

    	// Manage iptc classifications	
		foreach ( $meanings['categoryMatches'] as $category_match ) {
			wl_write_log( "wordlift interpreter: Add {var_dump($category_match)} to post {$post_id}" );
			wl_add_iptc_classification_to_post( 
				$post_id, $category_match['category']['label'], $category_match['category']['code'] 
				);  
		}

		foreach ( $meanings['topics'] as $entity ) {
			    		
			$entity_label = $entity['label'] . ' ('. $entity['id'] . ')';
			$entity = get_page_by_title( $entity_label, OBJECT, 'entity' );
			
			// If entity does not exists go on.
			if ( null === $entity ) {
				// Save entity on WP and Redlink
				wl_linked_data_save_entity( 
					'', $entity_label, $entity['type'], '', array( $entity['type'] ), array(), $post_id, array( $entity['itemId'] ) 
				);	
			// Add the related post ID if provided.
			} else {
				// Add related entities or related posts according to the post type.
				wl_add_related( $post_id, $entity->ID );
				// And vice-versa (be aware that relations are pushed to Redlink with wl_push_to_redlink).
				wl_add_related( $entity->ID, $post_id );
			}

		}
    
	return true;
}
function wl_manage_meanings_for( $post_id ) {

	remove_action( 'wordlift_save_post', 'wl_manage_meanings_for' );
	wl_set_meanings_for_post( $post_id, wl_get_meanings_for_post( $post_id ) );
	add_action( 'wordlift_save_post', 'wl_manage_meanings_for', 10 );

}

add_action( 'wordlift_save_post', 'wl_manage_meanings_for', 10 );


