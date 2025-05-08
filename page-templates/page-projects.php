<?php
/**
 * Template Name: Projects
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


 function echoProject($p, $classes=''){
     $link = get_field('links_to_page',$p->ID) ? get_field('linked_page',$p->ID) : get_the_permalink($p->ID);
     ?>
     <div class="grid-x grid-margin-x grid-padding-x projects-grid <?= $classes ?>" id="project-<?= $p->ID; ?>">
         <div class="cell large-1 large-order-1 small-order-1 icon-col">
             <?= getACFImgTag(get_field('icon',$p->ID),false,'project-icon'); ?>
         </div>
         <div class="cell large-6 text-cell large-order-2 small-order-3">
             <a class="no-underline" href="<?= $link ?>">
                 <h2 class="event-title">
                     <?= get_the_title($p->ID); ?>
                 </h2>
             </a>
             <div class="content">
                 <?= get_field('teaser',$p->ID); ?>
             </div>
             <?php addBtn(['url' => $link,'target'=>'_self','title' => __('Mehr erfahren','pol')],'left-align dark-outline') ?>
         </div>
         <div class="cell large-5 rel img-cell large-order-3 small-order-2">
             <div class="project-thumb" <?= getACFImgStyle(['url' => getThumbnailInSize('medium_large',$p->ID)],false) ?>></div>
         </div>
     </div>
     <?php
 }

//make sure to load the main post before entering.
if(!in_the_loop() && have_posts()) the_post();
 ?>
<div class="page-projects">
    <section class="site-block-container pad-75">
        <div class="site-block">
            <?php addSiteIconHeader(); ?>

            <div class="map hide-for-small-only" data-smooth-scroll>
                <?= getACFImgTag(get_field('map'),false); ?>

                <?php while(have_rows('spots')){
                    the_row();
                    $pid = get_sub_field('project');
                    $inactive = false;
                    if(!empty($pid)){
                        $pid = $pid->ID;
                        $inactive = get_field('inactive',$pid);
                    }
                    $pos = explode('/',get_sub_field('pos'));
                    $style = "style=\"top:{$pos[1]}%;left:{$pos[0]}%\" ";
                    $tooltip = get_sub_field('tooltip');
                    if($inactive) $tooltip .= __(' (inaktiv)','pol');
                    if(!empty($tooltip)) $tooltip = 'data-tooltip tabindex="1" title="'.$tooltip.'"';
                    ?>
                    <a class="no-underline" <?= empty($pid) ? '' : 'href="#project-'.$pid.'"'  ?>">
                        <?= getACFImgTag(get_sub_field('icon'),false,'spot top ' . ($inactive ? 'inactive' : '' ),'medium',$style . (empty($pid)?'':'pid="'.$pid.'"; ') . $tooltip); ?>
                    </a>
                    <?php

                } ?>
            </div>


            <?php
            $allProjects = get_posts(['post_type' => 'projekte','posts_per_page' => 999]);

            foreach ($allProjects as $p){
                if(get_field('inactive',$p->ID)) continue;
                echoProject($p);
            } ?>


            <?php

            addTitleHeader(__('Ruhende Projekte','pol'));

            foreach ($allProjects as $p){
                if(get_field('inactive',$p->ID) == false) continue;
                echoProject($p,'inactive');
            } ?>


        </div>
    </div>
</div>
 <?php get_footer();
