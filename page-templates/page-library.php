<?php
/**
 * Template Name: Library
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

//Shortcodes for this page

//make sure to load the main post before entering.
if(!in_the_loop() && have_posts()) the_post();
 ?>
<div class="page-library">
    <section class="site-block-container pad-75">
        <div class="site-block">
            <?php addSiteIconHeader(); ?>

            <div class="back-btn">
                <a class="no-underline" href="<?= get_field('projects_page', 'option'); ?>"><?= __('Zurück zur Karte', 'pol'); ?>
                </a>
            </div>

            <div class="grid-x grid-margin-x grid-padding-x align-center">
                <div class="cell large-8 medium-6">

                    <div class="grid-x filters grid-padding-x">
                        <div class="cell medium-4">
                            <div class="title">
                                <?= __('Suche:','pol'); ?>
                            </div>
                            <div class="input">
                                <input class="js-book-search" type="text" placeholder="<?= __('Suchbegriff eingeben','pol'); ?>" >
                            </div>
                        </div>
                        <div class="cell medium-4">
                            <div class="inner rel">
                                <div class="title">
                                    <?= __('Kategorie:','pol'); ?>
                                </div>
                                <div id="cat-dropdown-head" class="dropdown-head" data-toggle="cat-dropdown">
                                    <?= __('Alle Kategorien','pol'); ?>
                                </div>

                                    <div id="cat-dropdown" class="dropdown-pane" data-dropdown>
                                        <div class="js-cat-select" data-cat="*"><?= __('Alle Kategorien','pol'); ?></div>
                                        <?php
                                            $cats = get_terms(['taxonomy' => 'bookcat']);
                                            foreach ($cats as $cat){
                                                ?>
                                                <div class="js-cat-select" data-cat="<?= $cat->slug; ?>">
                                                    <?= $cat->name; ?>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                            </div>
                        </div>
                        <div class="cell medium-4">
                            <div class="inner rel">
                                <div class="title"> <?= __('Status:','pol'); ?> </div>
                                <div id="status-dropdown-head" class="dropdown-head rel" data-toggle="status-dropdown"> <?= __('alle','pol'); ?> </div>

                                    <div id="status-dropdown" class="dropdown-pane" data-dropdown>
                                        <div class="js-status-select" data-status="*"><?= __('alle','pol'); ?></div>
                                        <div class="js-status-select rel" data-status="available"><?= __('verfügbar','pol'); ?> <div class="icon available"></div></div>
                                        <div class="js-status-select rel" data-status="rented"><?= __('verliehen','pol'); ?> <div class="icon rented"></div></div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <?php the_content(); ?>

                    <div class="books-container">
                        <div class="empty-results hide">
                            <?= __('Keine Bücher zu dieser Suche gefunden.','pol'); ?>
                        </div>
                        <ul class="accordion" data-accordion  data-multi-expand="true" data-allow-all-closed="true">
                        <?php
                            $books = get_posts(['post_type' => 'buecher','posts_per_page' => 999]);
                            foreach ($books as $b){
                                $status = get_field('status',$b->ID);
                                $cats = wp_get_post_terms($b->ID,'bookcat');
                                $cats = implode(',',array_map(function($t){return $t->slug;},$cats));
                                ?>
                                <li class="accordion-item" data-accordion-item data-cat="<?= $cats ?>" data-status="<?= $status ?>">
                                    <?= getAssetsImgTag('accordion-down.svg',false,'open-arrow'); ?>
                                    <a href="#" class="no-underline accordion-title" aria-expanded="false">
                                        <div class="book">
                                            <div class="title"> <?= $b->post_title; ?> </div>
                                            <div class="sub"><?= get_field('subtitle',$b); ?></div>
                                            <?= getACFImgTag(['url'=>getThumbnailInSize('medium',$b),'alt'=>$b->post_title],false,'book-icon'); ?>
                                            <div class="status <?= $status ?>"></div>
                                        </div>
                                    </a>

                                    <div class="accordion-content" data-tab-content aria-expanded="false">
                                        <div class="book-description">
                                            <?= $b->post_content; ?>
                                        </div>
                                        <?php
                                            $ppl = get_field('people',$b);
                                            if(!empty($ppl)){
                                                ?>
                                                    <p class="people-title"><?= __('Um mehr über dieses Buch zu erfahren oder es auszuleihen, kontaktiere:','pol');?></p>
                                                    <div class="people">
                                                        <?php
                                                        foreach ($ppl as $p){
                                                            ?><a href="<?= get_the_permalink($p) ?>">
                                                            <?= getThumbImgTag($p,false,'','thumbnail');  ?>
                                                            <div class="name ">
                                                                 <?= $p->post_title; ?>
                                                            </div>
                                                            </a><?php
                                                        }
                                                        ?>
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </li>
                                <?php
                            }
                        ?>

                    </div>

                </div>


                <div class="cell large-4 medium-6 ">
                    <?= get_sidebar('library'); ?>
                </div>
            </div>


        </div>
    </div>
</div>
 <?php get_footer();
