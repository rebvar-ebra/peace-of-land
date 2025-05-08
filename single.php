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

    <div class="single-post">
        <section class="site-block-container pad-75">
            <div class="site-block grid-container">


                <div class="grid-x grid-margin-x align-center">
                    <div class="cell large-8 longtext ">
                        <div class="back-btn">
                            <a class="no-underline" href="<?= get_the_permalink(get_field('blog_page', 'option')->ID); ?>"><?= __('Alle Artikel','pol'); ?>
                            </a>
                        </div>
                        <h1><?= get_the_title(); ?></h1>
                        <div class="subtitle">
                            <?php
                            $date = get_post_time('d F Y',false,null,true);
                            $author = get_the_author();
                            echo sprintf(__('Gepostet am %s von %s','pol'),$date,$author);
                            ?>
                        </div>
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
    </div>

    </div>

<?php

get_footer();
