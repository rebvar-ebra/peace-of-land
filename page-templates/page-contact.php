<?php
/**
 * Template Name: Contact
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

 get_header();
wp_enqueue_script('gmaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDIdTV7nilo2y2ozEQ51NM3vdahp-xFfJQ');


//Shortcodes for this page

function runNLShortcode($atts, $content){
    $fid = get_field('newsletter_form');
    return empty($fid) ? '' : do_shortcode('[uberform id="'. $fid->ID.'"]');
}
function runCFShortcode($atts, $content){
    $fid = get_field('contact_form');
    return empty($fid) ? '' : do_shortcode('[uberform id="'. $fid->ID.'"]');
}
function runImgShortcode($atts, $content){

    if(!isset(get_field('icons')[$atts[0]-1])) return $content;

    ob_start();
        echo '<div class="inline-icon-wrapper">';
        echoACFImgTag(get_field('icons')[$atts[0]-1],false,'inline-icon','thumbnail');
        echo $content;
        echo '</div>';

    return ob_get_clean();
}

function runMapShortcode($atts, $content){
    ob_start();
    ?>
    <div class="acf-map">
        <?php $location = get_field('map');; ?>
        <div class="marker" data-lat="<?php echo $location['lat']; ?>"
             data-lng="<?php echo $location['lng']; ?>">
        </div>
    </div>
    <?php
    return ob_get_clean();
}



add_shortcode('newsletter','runNLShortcode');
add_shortcode('form','runCFShortcode');
add_shortcode('img','runImgShortcode');
add_shortcode('map','runMapShortcode');

//make sure to load the main post before entering.
if(!in_the_loop() && have_posts()) the_post();
 ?>
<div class="page-contact">
    <section class="site-block-container pad-75">
        <div class="site-block">
            <?php addSiteIconHeader(); ?>

            <div class="grid-x grid-margin-x grid-padding-x align-center">
                <div class="cell large-6 medium-6">
                    <?php the_content(); ?>
                </div>
                <div class="cell large-4 medium-6 large-offset-2">
                    <?= do_shortcode(get_field('sidebar_content')); ?>
                </div>
            </div>


        </div>
    </div>
</div>
 <?php get_footer();
