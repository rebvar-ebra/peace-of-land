<?php
/**
 * Created by PhpStorm.
 * User: shabananda
 * Date: 12.05.17
 * Time: 11:21
 *
 * To integrate Form use following demo markup:
 *
 * <form id="join-nl-form" data-abide>
<input id="nl-name" type="text" name="name" placeholder="Your Name..." value="Ilya"/>
<input id="nl-email" type="email" name="email" placeholder="Your Email..." value="me@ilya.sh"/>
<button class="black" type="submit">Submit</button>
</form>
 *
 */

//function for service handling
function runPostQuery($local){

    $src = $_POST;
    if(!empty($local)){
        $src = $local;
    }

    $ppp = get_field('blogposts_per_page', 'option');

    $q = new WP_Query(['post_type' => 'post',
        'post_status' => 'publish',
        'orderby' => 'post_date',
        'order' => 'DESC',
        'offset' => intval($src['page']) * $ppp,
        'posts_per_page' => $ppp]);

    $res = ['success' => true,
        'is_last_page' => ($q->max_num_pages-1) <= intval($src['page']),
        'page' => intval($src['page']),
        'debug' => ''];

    ob_start();
    while($q->have_posts()){
        $q->the_post();
        addBlogTeaser();
    }

    $res['html'] = ob_get_clean();
    wp_reset_query();

    if($local){
        return $res;
    }else{
        header( 'Content-type: application/json' );
        echo json_encode( $res );
        exit;
    }
}

//add the listener for the service
$serviceName = 'post_query';
add_action( 'wp_ajax_nopriv_'.$serviceName, 'runPostQuery' );
add_action( 'wp_ajax_'.$serviceName, 'runPostQuery' );
