<?php
/**
 * Needed by WP
 * User: artifex
 * Date: 09.10.18
 * Time: 14:04
 */



$people = get_field('people');

?>

<aside class="sidebar">

    <?php
    $infos = get_field('infos_and_contact');
    if(!empty($infos)){ ?>
        <div class="sidebar-box text">
            <div class="title"> <?= __('Infos & Kontakt','pol');?> </div>
            <?= do_shortcode($infos); ?>
        </div>
    <?php } ?>

    <?php if(!empty($people)){ ?>
        <div class="sidebar-box people">
            <div class="title"> <?= __('Menschen','pol');?> </div>
            <div class="people-inner">
                <?php
                foreach ($people as $p){
                    ?>
                    <a href="<?= get_the_permalink($p->ID) ?>" class="person">
                        <img src="<?= getThumbnailInSize('medium_large',$p->ID); ?>" alt="<?= get_the_title($p->ID); ?>">
                        <div class="name">
                            <?= get_the_title($p->ID); ?>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
    <?php } ?>


</aside>

