<?php
/**
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


//make sure to load the main post before entering.
if(!in_the_loop() && have_posts()) the_post();
 ?>
<div class="page-default">
    <section class="site-block-container pad-75">
        <div class="site-block text-center">
            <?php addSiteIconHeader(); ?>

            <div class="grid-x text-left align-center">
                <div class="cell large-10 longtext">
                    <?php the_content(); ?>
                </div>
            </div>

        </div>
    </div>
</div>
 <?php get_footer();
