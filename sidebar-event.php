<?php
/**
 * Needed by WP
 * User: artifex
 * Date: 09.10.18
 * Time: 14:04
 */



$people = get_field('people');
$people_org = get_field('people_organizers');

$projects = get_posts(array(
    'post_type' => 'projekte',
    'posts_per_page' => 999,
    'meta_query' => array(
        array(
            'key' => 'events', // name of custom field
            'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
            'compare' => 'LIKE'
        )
    )
));

$tax = get_the_terms(null,'type');
if(empty($tax)){
    echo '<h2>Fehler: Veranstaltungstyp ist nicht ausgewählt.</h2>';
}else if(count($tax) != 1){
    echo '<h2>Fehler: Mehr als ein Veranstaltungstyp ausgewählt.</h2>';
}

$tax = array_pop($tax);

$isPast = get_field('start_date',null,false) < time();


?>

<aside class="sidebar">



    <?php if(!empty(get_field('start_date'))){ ?>

        <div class="sidebar-box time-and-location rel">
            <div class="heading ">
                <?= getACFImgTag(get_field('img',$tax),false); ?>
                <div class="subtitle" style="color:<?= get_field('color',$tax);?>">
                    <?= $tax->name; ?>
                </div>
            </div>
            <div class="title"> <?= __('Zeit & Ort','pol');?> </div>
            <div class="date">
                <?= getAssetsImgTag('Uhrzeit.svg',false); ?>
                <div class="content">
                    <?php
                        $start = get_field('start_date', null, false);
                        $end = get_field('end_date', null, false);
                        setlocale(LC_ALL, 'de_DE');
                        echo strftime('%A, %d.%m.%Y - %H:%M Uhr ',$start);
                        if(!empty($end)){
                            echo '<br/>'.__('bis','pol').'<br/>';
                            echo strftime('%A, %d.%m.%Y - %H:%M Uhr ',$end);
                        }
                    ?>
                    <?php if(!$isPast){
                        ?>
                            <form method="post" action="http://pol.dv/wp-content/themes/peaceofland/library/ajax/ical.php">
                                <input type="hidden" name="eid" value="<?= get_the_ID()?>">
                                <input type="hidden" name="location" value="<?= str_replace("\r\n",' ',strip_tags(get_field('location'))); ?>">
                                <input type="hidden" name="description" value="<?= get_the_excerpt();?>">
                                <input type="hidden" name="dtstart" value="<?= str_replace('/','-',get_field('start_date')) ?>">
                                <input type="hidden" name="dtend" value="<?= str_replace('/','-',get_field('end_date')) ?>">
                                <input type="hidden" name="summary" value="<?= get_the_title(); ?>">
                                <input type="hidden" name="url" value="<?= get_the_permalink(); ?>">
                                <input type="submit" value="<?= __('Zum Kalender hinzufügen','pol'); ?>">
                            </form>
                    <?php
                    } ?>
                </div>

            </div>

        <?php
        } ?>


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
    $costs = get_field('costs');
    if(!empty($costs)&&!$isPast){ ?>
        <div class="sidebar-box text">
            <div class="title"> <?= __('Kosten','pol');?> </div>
            <?= do_shortcode($costs); ?>
        </div>
    <?php } ?>



    <?php
    $infos = get_field('infos');
    if(!empty($infos) && !$isPast){ ?>
        <div class="sidebar-box text">
            <div class="title"> <?= __('Anmelden & Infos','pol');?> </div>
            <?= do_shortcode($infos); ?>
        </div>
    <?php } ?>

    <?php
    $booking = get_field('booking_link');
    if(!empty($booking) && !$isPast){ ?>
        <div class="sidebar-box text">
            <div class="title"> <?= __('Kurs buchen','pol');?> </div>
            <p><?= __('Kurs über unser Buchungstool buchen.') ?></p>
            <?= addBtn('booking_link','dark-outline left-align'); ?>
        </div>
    <?php } ?>


    <?php if(!empty($people)||!empty($people_org)){ ?>
        <div class="sidebar-box people">
            <?php if(!empty($people)){
                ?>
                    <div class="title"> <?= __('Kursleitung','pol');?> </div>
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
                <div class="title"> <?= __('Organisation','pol');?> </div>
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


</aside>

