<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header();

$mbp = get_field('blog_page','option');
?>
    <div class="page-blog">
        <section class="site-block-container pad-75">
            <div class="site-block">
                <?php
                setlocale(LC_ALL,'de_DE');
                $d = strftime('%B',strtotime('1.'.get_query_var('monthnum').'.'.get_query_var('year')));
                addSiteIconHeader($mbp->ID, sprintf(__('Blog - %s %s','pol'), $d,get_query_var('year')));
                ?>

                <div class="grid-x grid-margin-x ">
                    <div class="cell large-8">
                        <?php

                        while(have_posts()){
                            the_post();
                            addBlogTeaser();
                        }

                        addBtn(['title'=>__('Zurück zum Blog','pol'),'url' => get_the_permalink($mbp->ID),'target'=>'_self']);
                        ?>
                    </div>
                    <div class="cell large-4 show-for-large">
                        <?= get_sidebar(); ?>
                    </div>
                </div>

            </div>
    </div>


    </div>
<?php get_footer();
