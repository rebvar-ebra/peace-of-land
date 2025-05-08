<?php
/**
 * Template Name: Events
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


function echoEvent($e, $classes="",$isPast = false){
    $tax = get_the_terms($e->ID,'type');
    if(empty($tax)){
        echo '<h2>Fehler: Veranstaltungstyp ist nicht ausgewählt.</h2>';
    }
    else{
        $tax = array_pop($tax);
    }
    ?>
    <div class="grid-x grid-margin-x grid-padding-x events-grid <?= $classes; ?>">
        <div class="cell large-1 large-order-1 small-order-1">
            <div class="date rel">
                <?php $d = get_field('start_date', $e->ID,false);
                $months = __('Jan,Feb,Mär,Apr,Mai,Jun,Jul,Aug,Sep,Okt,Nov,Dez','pol');
                $months = explode(',',$months);
                $m = $months[date('m',$d)-1];
                ?>
                <div class="inner abs-centered">
                    <div class="day"><?= date('d',$d); ?></div>
                    <div class="month"><?= $m; ?></div>
                </div>
            </div>
        </div>
        <div class="cell large-6 text-cell large-order-2 small-order-3">
            <a class="no-underline" href="<?= get_the_permalink($e->ID); ?>">
                <h2 class="event-title">
                    <?= get_the_title($e->ID); ?>
                </h2>
            </a>
            <div class="content">
                <?= get_field('teaser',$e->ID); ?>
            </div>
            <?php addBtn(['url' => get_the_permalink($e->ID),'target'=>'_self','title' => $isPast ? __('Mehr erfahren','pol') : __('Mehr erfahren & anmelden','pol')]) ?>
        </div>
        <div class="cell large-5 rel img-cell large-order-3 small-order-2">
            <div class="event-thumb" <?= getACFImgStyle(['url' => getThumbnailInSize('medium_large',$e->ID)],false) ?>></div>
            <?= getACFImgTag(get_field('img',$tax),false,'icon','medium_large'); ?>
        </div>
    </div>
    <?php
}


//make sure to load the main post before entering.
if(!in_the_loop()&&have_posts()){
    the_post();
}
?>
    <div class="page-events">
        <section class="site-block-container pad-75">
            <div class="site-block">
                <?php addSiteIconHeader(); ?>

                <?php

                $allEvents = get_posts(['post_type' => 'veranstaltungen',
                    'meta_key' => 'start_date',
                    'orderby' => 'start_date',
                    'posts_per_page' => 999,
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key'		=> 'start_date',
                            'compare'	=> '>=',
                            'value'		=>  date('Y/m/d H:i:s'),
                            'type'  	=> 'DATETIME'
                        )

                    )]);


                $types = [];
                ?><div class="grid-x grid-margin-x legend align-center"><?php
                    $evTypes = get_terms(['taxonomy'=>'type','hide_empty'=>false]);
                    foreach ($evTypes as $e){
                        ?>
                        <div class="legendicon cell">
                            <?= getACFImgTag(get_field('img',$e),false) ?>
                            <div class="sub" style="color:<?= get_field('color',$e);?>">
                                <?= $e->name; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <?php foreach ($allEvents as $e){
                    echoEvent($e);
                } ?>


                <?php

                addTitleHeader(__('Vergangene Veranstaltungen','pol'));


                $pastEvents = get_posts(['post_type' => 'veranstaltungen',
                    'meta_key' => 'start_date',
                    'orderby' => 'start_date',
                    'posts_per_page' => 999,
                    'order' => 'DESC',
                    'meta_query' => array(
                        array(
                            'key'		=> 'start_date',
                            'compare'	=> '<',
                            'value'		=>  date('Y/m/d H:i:s'),
                            'type'  	=> 'DATETIME'
                        )

                    )]);

                foreach ($pastEvents as $e){
                    echoEvent($e,'past-events',true);
                } ?>

            </div>

        </section>
    </div>
<?php

get_footer();
