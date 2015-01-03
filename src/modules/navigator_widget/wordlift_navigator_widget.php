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

    // get the current post id.
    $post_id = get_the_ID();
    $depth = 5;
    
    // get the related posts and entities.
    $related_posts = wl_shortcode_chord_get_relations( $post_id, $depth );
    var_dump($related_posts);
    
    $content = '<div class="your-class">';
    foreach ( $related_posts as $related_post ) {
        $content .= '<div><img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcSEHnG0mWIkoluzMx0KeHxFjdNYTr2vPwulkxRh11j6aFYytld9iw"></div>';
    }
    $content .= '</div>';

    $content .= '<script>$=jQuery; $(document).ready(function(){
            $(".your-class").slick({
                dots: true,
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 1
            });
        });
    </script>';
    
    return $content;
}

add_action( 'init', 'wordlift_register_shortcode_navigator');

