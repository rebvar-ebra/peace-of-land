<?php
/**
 * Needed by WP
 * User: artifex
 * Date: 09.10.18
 * Time: 14:04
 */



$projects = get_posts(array(
    'post_type' => 'projekte',
    'posts_per_page' => 999,
    'meta_query' => array(
        array(
            'key' => 'people', // name of custom field
            'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
            'compare' => 'LIKE'
        )
    )
));

$events = get_posts(['post_type' => 'veranstaltungen',
    'meta_key' => 'start_date',
    'posts_per_page' => 6,
    'orderby' => 'start_date',
    'order' => 'ASC',
    'meta_query' => array(
            'relation' => 'AND',
        array(
            'key'		=> 'start_date',
            'compare'	=> '>=',
            'value'		=>  date('Y/m/d H:i:s'),
            'type'  	=> 'DATETIME'
        ),
        array(
            'key' => 'people', // name of custom field
            'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
            'compare' => 'LIKE'
        )
    )]);

$pastEvents = [];
if(count($events) < 6){
    $pastEvents = get_posts(['post_type' => 'veranstaltungen',
        'meta_key' => 'start_date',
        'posts_per_page' => 6 - count($events),
        'orderby' => 'start_date',
        'order' => 'DESC',
        'meta_query' => array(
                'relation' => 'AND',
            array(
                'key'		=> 'start_date',
                'compare'	=> '<',
                'value'		=>  date('Y/m/d H:i:s'),
                'type'  	=> 'DATETIME'
            ),
            array(
                'key' => 'people', // name of custom field
                'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )]);
}


?>

<aside class="sidebar">

    <?php if(!empty($projects)){ ?>
        <div class="sidebar-box projects">
            <div class="title"> <?= __('Projekte','pol');?> </div>

            <?php
            foreach ($projects as $p){
                $tooltip = 'data-tooltip tabindex="1" title="'.get_the_title($p->ID).'"';
                echoACFImgTag(get_field('icon',$p->ID),false,'','thumbnail',$tooltip,get_the_permalink($p->ID),'_self','no-underline');
            }
            ?>
        </div>
    <?php } ?>

    <?php if(!empty($events) ||!empty($pastEvents)){ ?>
        <div class="sidebar-box events">

            <?php if(!empty($events)){
                ?>
                    <div class="title"> <?= __('Veranstaltungen','pol');?> </div>

            <?php
            } ?>

            <?php
            foreach ($events as $e){
                ?>
                <div class="datetime">
                    <?= getEventDate($e->ID) ?>
                </div>
                <a class="event-title no-underline" href="<?= get_the_permalink($e->ID); ?>">
                    <?php
                    $t = get_field('short_title',$e->ID);
                    echo empty($t) ? get_the_title($e->ID) : $t; ?>
                </a>
                <?php
            }

            if(!empty($pastEvents)){
             ?>

                <div class="title"> <?= __('Vergangene Veranstaltungen','pol');?> </div>
                <?php

                foreach ($pastEvents as $e){
                    ?>
                    <div class="datetime past-event">
                        <?= getEventDate($e->ID) ?>
                    </div>
                    <a class="event-title no-underline past-event" href="<?= get_the_permalink($e->ID); ?>">
                        <?php
                        $t = get_field('short_title',$e->ID);
                        echo empty($t) ? get_the_title($e->ID) : $t; ?>
                    </a>
                    <?php
                }
            }
            ?>
        </div>
    <?php } ?>

    <?php
    $email = get_field('email');
    if(!empty($email)){ ?>
        <div class="sidebar-box contact">
            <div class="title"> <?= __('Kontaktieren','pol');?> </div>
            <div class="email">
                <a class="no-underline" href="mailto:<?= $email; ?>">
                    <?= $email; ?>
                </a>
            </div>
        </div>
    <?php } ?>



</aside>

