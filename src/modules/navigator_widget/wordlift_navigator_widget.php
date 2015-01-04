<?php
/**
 * Shortcode to print the in-post navigator
 */

function wordlift_register_shortcode_navigator() {
    add_shortcode('wl-navigator', 'wordlift_shortcode_navigator');
}

function wordlift_shortcode_navigator_populate( $post_id ) {
    
    // add as first the most recent article in the same iptc category
    $related_posts = wl_iptc_get_most_recent_post_in_same_category( $post_id );
    if( isset( $related_posts->ID ) ) {
        $related_posts = array( $related_posts->ID );
    } else {
        $related_posts = array();
    }
    
    // get the related entities, and for each one retrieve the most recent post regarding it.
    $related_entities = wl_get_referenced_entity_ids( $post_id );
    foreach ( $related_entities as $rel_entity ) {
        
        // take the id of posts referencing the entity
        $referencing_posts = wl_get_referencing_posts( $rel_entity );
        
        // loop over them and take the first one which is not already in the $related_posts
        foreach ( $referencing_posts as $referencing_post ) {
            if( isset( $referencing_post->ID ) && !in_array( $referencing_post->ID, $related_posts ) ) {
                $related_posts[] = $referencing_post->ID;
                break;
            }
        }
    }
    
    return $related_posts;
}

function wordlift_shortcode_navigator() {

    // include mobifyjs on page
    wp_enqueue_script( 'slick-js', plugins_url( 'js-client/slick/slick.min.js', __FILE__ ) );
    wp_enqueue_style( 'slick-css', plugins_url( 'js-client/slick/slick.css', __FILE__ ) );
        
    // get the current post.
    $post = get_post( get_the_ID() );
    
    // get posts that will populate the navigator (criteria may vary, see function)
    $related_posts = wordlift_shortcode_navigator_populate( $post->ID );
    
    $content = '<div id="wl-navigator-widget">';
    foreach ( $related_posts as $related_post_id ) {
        
        $related_post = get_post( $related_post_id );
        
        $thumb = get_the_post_thumbnail( $related_post_id, 'thumbnail' );
        if( empty( $thumb ) ) {
            $thumb = '<img src="' . plugins_url('js-client/slick/missing-image-150x150.png', __FILE__ ) . '" />';
        }
        
        $category_link = get_iptc_category_links( $related_post_id, true );
        $category_name = get_iptc_category_names( $related_post_id, true );
        
        $content .= '<div class="wl-navigator-card">'
            . $thumb .
            '<a class="wl-navigator-trigger" href="' . get_permalink( $related_post_id ) . '">' . $related_post->post_title . '</a>
            <a class="wl-navigator-context" href="' . $category_link . '">' . $category_name . '</a>
        </div>';
    }
    $content .= '</div>';

    $content .= '<script>$=jQuery; $(document).ready(function(){

            // Some css fixing
            $(".wl-navigator-card > img").addClass("wl-navigator-lens");
            setInterval( function(){
                $(".slick-prev, .slick-next").css("background", "gray");
            }, 500);
            
            // Launch navigator
            $("#wl-navigator-widget").slick({
                dots: true,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1
            });
        });
    </script>';
    
    return $content;
}

add_action( 'init', 'wordlift_register_shortcode_navigator');

