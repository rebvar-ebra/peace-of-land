<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header();

if(!in_the_loop() && have_posts()) the_post();
?>

    <div class="single-member">
        <section class="site-block-container pad-75">
            <div class="site-block">

                    <div class="back-btn">
                        <a class="no-underline" href="<?= get_field('people_page', 'option'); ?>"><?= __('Alle Menschen','pol'); ?>
                        </a>
                    </div>

                <div class="grid-x grid-margin-x">
                    <div class="cell large-7 longtext ">
                        <img class="headshot" src="<?= getThumbnailInSize('large'); ?>" alt="<?= get_the_title(); ?>">
                        <?php the_content(); ?>
                    </div>
                    <div class="cell large-4 large-offset-1">
                        <?= get_sidebar('person'); ?>
                    </div>
                </div>
            </div>
    </div>

    </div>

<?php

get_footer();
