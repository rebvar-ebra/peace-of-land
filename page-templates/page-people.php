<?php
/**
 * Template Name: People
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
<div class="page-people">
    <section class="site-block-container pad-75">
        <div class="site-block">
            <?php addSiteIconHeader(); ?>

            <div class="grid-x grid-margin-x align-center">
                <?php
                    $allPeople = get_posts(['post_type' => 'mitglieder','posts_per_page' => 999]);
                    shuffle($allPeople);
                    foreach ($allPeople as $person){
                        addPersonCard($person->ID);
                    }
                ?>
            </div>


        </div>
    </div>
</div>
 <?php get_footer();
