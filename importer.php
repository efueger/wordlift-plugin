<?php
 
define('MY_WP_PATH', '/Users/mcolacino/src/wordlift/wordpress_3.9'); 
require_once( MY_WP_PATH . '/wp-load.php' );
define('MY_ADMIN_USER_ID', 1); 
define('MY_API_ENDPOINT', 'http://192.168.1.108:8080/article'); 

	$response = wp_remote_request( MY_API_ENDPOINT );
	// Process only valid responses.
	if ( ! is_wp_error( $response ) && 200 === (int)$response['response']['code'] ) {
		
		$remote_posts = json_decode( $response['body'], true );
		
		foreach ( $remote_posts as $index => $remote_posts ) {
			
			$url = explode( "/", $remote_posts['url'] );
			$slug = $url[6];
			
    		$post = array(
        		'post_title'    => $slug,
        		'post_content'  => $slug . '[wl-navigator]',
        		'post_status'   => 'publish',
        		'post_author'   => MY_ADMIN_USER_ID,
        		'post_type'     => 'post',
    		);

    		$post_id = wp_insert_post($post);
    		echo "Inserted post $slug with ID $post_id\n";

    		// wl_get_meanings_for_post($post_id);
			

		}

	} else {
		echo "There was an error\n";
	}	
	