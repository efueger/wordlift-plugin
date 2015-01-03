<?php
/**
 * Shortcode to print the in-post navigator
 */

function wordlift_register_shortcode_navigator() {
    add_shortcode('wl-navigator', 'wordlift_shortcode_navigator');
}

function wordlift_shortcode_navigator() {

    // Include mobifyjs on page
    wp_enqueue_script(
            'slick-js', plugins_url( 'js-client/slick/slick.min.js', __FILE__ )
    );
    wp_enqueue_style(
            'slick-css', plugins_url( 'js-client/slick/slick.css', __FILE__ )
    );

    
    
    // get the current post.
    $post = get_post( get_the_ID() );
    $depth = 5;
    
    // get the related posts and entities.
    $related_posts = wl_shortcode_chord_get_relations( $post->ID, $depth );
    var_dump($related_posts);
    
    $content = '<div id="wl-navigator-widget">';
    foreach ( $related_posts['entities'] as $related_post_id ) {
        var_dump($related_post);
        $related_post = get_post( $related_post_id );
        $thumb = get_the_post_thumbnail( $related_post_id, 'thumbnail' );
        if( empty( $thumb ) ) {
            $thumb = '<img />';
        }
        $content .= '<div class="wl-navigator-card">'
            . $thumb .
            '<span class="wl-navigator-trigger">' . $related_post->post_title . '</span>
            <span class="wl-navigator-contest">' . $related_post->post_title . '</span>
        </div>';
    }
    $content .= '</div>';

    $content .= '<script>$=jQuery; $(document).ready(function(){
            $(".wl-navigator-card > img").addClass("wl-navigator-lens");
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

