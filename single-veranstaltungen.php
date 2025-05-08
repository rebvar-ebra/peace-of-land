<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header();

if(!in_the_loop() && have_posts()) the_post();

$isPast = get_field('start_date',null,false) < time();
?>

    <div class="single-event">
        <section class="site-block-container pad-75">
            <div class="site-block">

                <div class="back-btn">
                    <a class="no-underline" href="<?= get_field('events_page', 'option'); ?>"><?= __('Alle Veranstaltungen','pol'); ?>
                    </a>
                </div>

                <div class="grid-x grid-margin-x">
                    <div class="cell large-7 longtext ">
                        <h1><?= get_the_title(); ?></h1>
                        <?php if($isPast){
                            ?><div class="past-event-hint"><?= __('Dies ist eine vergangene Verantaltung','pol'); ?></div><?php
                        } ?>
                        <?php the_content(); ?>
                    </div>
                    <div class="cell large-4 large-offset-1">
                        <?= get_sidebar('event'); ?>
                    </div>
                </div>
            </div>
    </div>

    </div>

<?php

get_footer();
