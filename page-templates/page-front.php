<?php
/**
 * Template Name: Front
 * User: shabananda
 * Date: 12/02/2017
 * Time: 15:15
 */

get_header();
?>
<div class="page-front">
    <section class="intro-header" responsive-bg-img>
        <?= getACFImgTag(get_field('header_img'),false,'',new ResponsiveSizeSetting(['url','large','medium_large']),'responsive-bg-img-src'); ?>
        <div class="tagline abs-centered">
              <h1><?= get_field('tagline'); ?></h1>
        </div>
    </section>

    <section class="site-block-container bg-white pad-75">
        <div class="site-block mission-block">
            <?= getACFImgTag(get_field('mission_icon'),false); ?>
            <div class="statement">
                <?= get_field('mission_statement'); ?>
            </div>

            <?php addBtn('mission_button'); ?>
        </div>
    </section>

<!--EVENTS-->

    <section class="site-block-container bg-beige pad-50 no-bottom">
        <div class="site-block events-block narrow">
            <?php addTitleHeader(get_field('events_title')); ?>

            <div class="grid-x grid-margin-x large-margin-collapse align-center">
                <?php
                if(have_rows('events')){
                    do{
                        $p = the_row();
                        addEventCard($p);
                    }while(have_rows('events'));
                }else{

                    $p = get_posts(['post_type' => 'veranstaltungen',
                        'meta_key' => 'start_date',
                        'orderby' => 'start_date',
                        'posts_per_page' => 3,
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                                'key'		=> 'start_date',
                                'compare'	=> '>=',
                                'value'		=>  date('Y/m/d H:i:s'),
                                'type'  	=> 'DATETIME'
                            )

                        )]);


                    foreach ($p as $pr) addEventCard($pr->ID);
                }

                ?>
            </div>

            <?php addBtn('events_button'); ?>
        </div>
    </section>

<!--PROJECTS -->

    <section class="site-block-container bg-beige pad-50 no-bottom">
        <div class="site-block projects-block narrow">
            <?php addTitleHeader(get_field('projects_title')); ?>
            <div class="grid-x grid-margin-x large-margin-collapse align-center">
                <?php
                if(have_rows('projects')){
                    while(have_rows('projects')){
                        $p = get_post(the_row());
                        if($p->post_status == 'publish'){

                            addProjectCard($p->ID);
                        }
                    };
                }else{
                    $allProjects = get_posts(['post_type'=>'projekte','posts_per_page'=>999]);
                    $p = [];
                    for ($i = 0; $i < 3; $i++) {
                        $np = array_splice($allProjects,rand(0,count($allProjects)-1),1)[0];
                        if(get_field('inactive',$np->ID) == true){
                            $i--;
                            continue;
                        }
                        array_push($p,$np);
                        if(count($allProjects) == 0) break;
                    }

                    foreach ($p as $pr) addProjectCard($pr->ID);
                }

                ?>
            </div>
            <?php addBtn('projects_button'); ?>
        </div>
    </section>


<!--PEOPLE-->

    <section class="site-block-container bg-beige pad-75">
        <div class="site-block people-block narrow" >
            <?php addTitleHeader(get_field('people_title'),get_field('people_sub_title')); ?>
            <div class="grid-x grid-margin-x large-margin-collapse align-center" >
                <?php

                $maxPPl = 4;
                if(have_rows('people')){
                    $ppl = get_field('people');
                    shuffle($ppl);

                    foreach ($ppl as $p){
                        addPersonCard($p->ID);
                        if(--$maxPPl <= 0) break;
                    }

                }else{
                    $p = get_posts(['post_type'=>'mitglieder','posts_per_page' => 999]);
                    shuffle($p);
                    foreach ($p as $pr){
                        addPersonCard($pr->ID);
                        if(--$maxPPl <= 0) break;
                    }
                }

                ?>
            </div>
            <?php addBtn('people_button'); ?>
        </div>
    </section>

    <section class="site-block-container bg-white">
        <div class="site-block narrow">
            <div class="supporter-block ">
                <h3 class="text-center"><?= get_field('support_title'); ?></h3>
                <p class="text-center"><?= get_field('support_sub_title'); ?></p>
                <div class="grid-x grid-margin-x align-center">
                    <?php
                        $gal = get_field('support_logos');
                        foreach ($gal as $img){
                            if(!empty($img['caption'])){
                                ?><a class="no-underline" target="_blank" href="<?= $img['caption']; ?>"><?php
                            }
                            ?>
                            <div class="cell shrink">
                                <?= getACFImgTag($img,true,'galimg','medium_large'); ?>
                            </div>
                            <?php
                            if(!empty($img['caption'])){
                                ?></a><?php
                            }
                        }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();