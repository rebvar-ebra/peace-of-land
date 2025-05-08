<?php
/**
 * Needed by WP
 * User: artifex
 * Date: 09.10.18
 * Time: 14:04
 */



$people = get_field('people');
$people_org = get_field('people_organizers');
$events = get_field('events');


//remove events that are over
$pastEvents = [];
if(!empty($events)){

$now = time();
for ($i = 0; $i < count($events); $i++){
    $ev = $events[$i];
    if(empty($ev)) continue;
    $startdate = get_field('start_date',$ev->ID,false);
    if($startdate <= $now){
        $pastEvents = array_merge($pastEvents,array_splice($events,$i,1));
        $i--;
    }
}
    //Sort events on date
    uasort($events, function($e1,$e2){
        return get_field('start_date',$e1->ID,false) > get_field('start_date',$e2->ID,false);
    });
    //Sort events on date
    uasort($pastEvents, function($e1,$e2){
        return get_field('start_date',$e1->ID,false) < get_field('start_date',$e2->ID,false);
    });
}

//crop the past events, so that no more than 6 events are shown

if(count($events) > 6) $pastEvents = [];
else{
    $pastEvents = array_splice($pastEvents,0,6-count($events));
}

$isInactive = get_post_status() == 'inactive';
?>

<aside class="sidebar">


    <?php if(!empty(get_field('date_and_time'))){
        ?>
            <div class="sidebar-box time-and-location rel">

                <div class="title"> <?= __('Zeiten & Ort','pol');?> </div>
                <div class="date">
                    <?= getAssetsImgTag('Uhrzeit.svg',false); ?>
                    <div class="content">
                        <?= get_field('date_and_time'); ?>
                    </div>

                </div>

                <?php if(!empty(get_field('location'))){ ?>
                <div class="location">
                    <?= getAssetsImgTag('MapPin.svg',false); ?>
                    <div class="content">
                        <?= get_field('location'); ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        <?php
    } ?>

    <?php if((!empty($pastEvents) ||!empty($events)) && !$isInactive){ ?>
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
                    <?php $t = get_field('short_title',$e->ID);
                    echo empty($t) ? get_the_title($e->ID) : $t; ?>
                </a>
                <?php
            }

            ?>

            <?php if(!empty($pastEvents)){
                ?>
                <div class="title"> <?= __('Vergangene Veranstaltungen','pol');?> </div>
                <?php
            } ?>

            <?php
            foreach ($pastEvents as $e){
                ?>
                <div class="datetime past-event">
                    <?= getEventDate($e->ID) ?>
                </div>
                <a class="event-title past-event no-underline" href="<?= get_the_permalink($e->ID); ?>">
                    <?php $t = get_field('short_title',$e->ID);
                    echo empty($t) ? get_the_title($e->ID) : $t; ?>
                </a>
                <?php
            }

            ?>
        </div>
    <?php } ?>


    <?php
    $infos = get_field('infos');
    if(!empty($infos)&& !$isInactive){ ?>
        <div class="sidebar-box text">
            <div class="title"> <?= __('Anmelden & Infos','pol');?> </div>
            <?= do_shortcode($infos); ?>
        </div>
    <?php } ?>


    <?php if(!empty($people)||!empty($people_org)){ ?>
        <div class="sidebar-box people">
            <?php if(!empty($people)){
                ?>
                <div class="title"> <?= __('Menschen','pol');?> </div>
                <div class="people-inner">
                <?php
                foreach ($people as $p){
                    ?>
                    <a href="<?= get_the_permalink($p->ID) ?>" class="person no-underline">
                        <img src="<?= getThumbnailInSize('medium_large',$p->ID); ?>" alt="<?= get_the_title($p->ID); ?>">
                        <div class="name">
                            <?= get_the_title($p->ID); ?>
                        </div>
                    </a>
                    <?php
                }
                ?>
                </div>
                <?php
            } ?>

            <?php if(!empty($people_org)){
                ?>
                <div class="title"> <?= __('Verantwortlich','pol');?> </div>
                <div class="people-inner">
                <?php
                foreach ($people_org as $p){
                    ?>
                    <a href="<?= get_the_permalink($p->ID) ?>" class="person no-underline">
                        <img src="<?= getThumbnailInSize('medium_large',$p->ID); ?>" alt="<?= get_the_title($p->ID); ?>">
                        <div class="name">
                            <?= get_the_title($p->ID); ?>
                        </div>
                    </a>
                    <?php
                }
                ?>
                </div>
                <?php
            } ?>
        </div>
    <?php } ?>


</aside>

