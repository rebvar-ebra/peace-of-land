<?php
/**
 * Template Name: Blog
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
 ?>
<div class="page-blog">
    <section class="site-block-container pad-75">
        <div class="site-block">
            <?php addSiteIconHeader();?>

            <div class="grid-x grid-margin-x ">
                <div class="cell large-8 ">
                    <div class="posts-container">
                        <?php

                        $wpq = new WP_Query(['post_type' => 'post', 'posts_per_page' => 3]);

                        $posts = runPostQuery(['page'=>0]);
                        echo $posts['html'];

                        ?>
                    </div>
                    <div class="button-container">
                        <?php

                        if(!$posts['is_last_page']){
                            addBtn(__('Ältere laden','pol'),'loadposts');
                        }

                        ?>
                    </div>
                </div>
                <div class="cell large-4">
                    <?= get_sidebar(); ?>
                </div>
            </div>

        </div>
</div>


</div>
 <?php
wp_reset_query();
get_footer();
