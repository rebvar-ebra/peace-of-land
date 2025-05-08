<?php
/**
 * Template Name: About Us
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
<div class="page-about pad-menu">
    <section class="site-block-container pad-75">
        <div class="site-block text-center">
            <?php addSiteIconHeader(); ?>

            <div class="grid-x text-left grid-margin-x align-center">
                <div class="cell large-5">
                    <?= getACFImgTag(get_field('main_img'),false,'' ,'large'); ?>
                </div>
                <div class="cell large-5 front-text">
                    <?= get_field('front_text'); ?>
                </div>
            </div>
            <div class="grid-x text-left bottom-text">
                <div class="cell large-7 large-offset-1">
                    <?= get_field('bottom_text'); ?>
                </div>
            </div>


        </div>
    </div>
</div>
 <?php get_footer();
