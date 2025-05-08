<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header();

if (!in_the_loop() && have_posts()) the_post();

$isInactive = get_post_status() == 'inactive';

?>

    <div class="single-project">
        <section class="site-block-container pad-75">
            <div class="site-block">

                <div class="back-btn">
                    <a class="no-underline" href="<?= get_field('projects_page', 'option'); ?>"><?= __('Zurück zur Karte', 'pol'); ?>
                    </a>
                </div>

                <div class="grid-x grid-margin-x">
                    <div class="cell large-7 longtext ">
                        <?= getACFImgTag(get_field('icon'), false, 'headericon'); ?>
                        <h1 class="text-center <?= $isInactive ? 'inactive' : ''; ?>"><?= get_the_title(); ?></h1>
                        <?php if($isInactive){
                            ?>
                            <div class="text-center">
                                <div class="inactive-project-hint">
                                    <?= __('Dieses Projekt ist zur Zeit inaktiv','pol'); ?>
                                </div>
                            </div>
                            <?php
                        } ?>
                        <?php the_content(); ?>
                    </div>
                    <div class="cell large-4 large-offset-1">
                        <?= get_sidebar('project'); ?>
                    </div>
                </div>
            </div>
    </div>

    </div>

<?php

get_footer();
