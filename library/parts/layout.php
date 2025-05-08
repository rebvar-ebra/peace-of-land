<?php
/**
 * General layouting templates file. Use instead of get_template_part which sucks. 
 * User: shabananda
 * Date: 20/03/2017
 * Time: 11:21
 */

function addBtn($linkField, $classes = 'dark-outline'){
    $btn = is_string($linkField) ? get_field($linkField) : $linkField;
    if(!empty($btn)){
        if(isset($btn['url'])){
            ?>
            <a href="<?= $btn['url'] ?>" class="no-underline" target="<?= $btn['target'] ?>"> <button class="<?= $classes; ?>"><?= $btn['title']; ?> </button></a>
            <?php
        }
    }else{
        ?>
        <button class="<?= $classes; ?>"><?= $linkField ?></button>
        <?php
    }
}
function addSiteIconHeader($pid = null, $title = null){
    ?>
    <div class="icon-header text-center">
        <?= getACFImgTag(get_field('header_icon',$pid),false,'header-icon','medium_large');?>
        <h1><?= empty($title) ? get_the_title($pid) : $title; ?></h1>
    </div>
    <?php
}

    function addSeparatorLine(){
    ?>
    <div class="separator"></div>
    <?php
}

function addTitleHeader($txt, $sub = ''){
    ?>
    <div class="title-bar">
        <h2> <?= $txt ?> </h2>
    </div>
    <?php if(!empty($sub)){ ?>
        <div class="title-bar-sub"> <?= $sub ?> </div>
    <?php }
}

function addPersonCard($pid){
    $img = ['sizes'=>['medium_large'=>getThumbnailInSize('medium_large',$pid)],'alt'=>''];
?>
    <article class="person-card">
        <a class="no-underline" href="<?= get_the_permalink($pid); ?>">
            <?= getACFImgTag($img,true,'person','medium_large'); ?>
        </a>
        <div class="inner">
            <a class="no-underline" href="<?= get_the_permalink($pid); ?>">
                <h3 equal-height="ppl"><?= get_the_title($pid); ?></h3>
            </a>
            <div class="content"> <?= get_the_excerpt($pid); ?> </div>
        </div>
        <a class="more animated-underline" href="<?= get_the_permalink($pid); ?>">
            <?= __('Mehr erfahren','pol'); ?>
        </a>
    </article>
    <?php
}
function addEventCard($pid){
    $t = get_field('short_title',$pid);
    if(empty($t)) $t = get_the_title($pid);
    $img = ['sizes'=>['medium_large'=>getThumbnailInSize('medium_large',$pid)],'alt'=>''];

    $tax = get_the_terms($pid,'type');
    if(empty($tax)){
        echo '<h2>! Fehler: Veranstaltungstyp ist nicht ausgewählt. -> '.print_r($pid,true).'</h2>';
    }else if(count($tax) != 1){
        echo '<h2>! Fehler: Mehr als ein Veranstaltungstyp ausgewählt.'.$pid.'</h2>';
    }

    $tax = array_pop($tax);
    addCard($t, get_the_excerpt($pid),$img, get_field('img',$tax),get_permalink($pid), getEventDate($pid));
}
function addProjectCard($pid){
    $t = get_field('short_title',$pid);
    if(empty($t)) $t = get_the_title($pid);
    $img = ['sizes'=>['medium_large'=>getThumbnailInSize('medium_large',$pid)],'alt'=>''];
    $link = get_field('links_to_page',$pid) ? get_field('linked_page',$pid) : get_the_permalink($pid);
    addCard($t, get_the_excerpt($pid),$img, get_field('icon',$pid),$link);
}
function addCard($title, $text, $acfImg, $acfIcon, $moreLink, $date = ''){
    ?>

    <article class="card">
        <?= getACFImgTag($acfIcon,false,'icon'); ?>
        <a class="no-underline" href="<?= $moreLink ?>">
            <div class="thumb" <?= getACFImgStyle($acfImg,false,'medium_large','cover') ?>></div>
        </a>
        <div class="inner">
            <?php if(!empty($date)){
                ?>
                <div class="datetime">
                    <?= $date; ?>
                </div>
                <?php
            } ?>
            <a class="no-underline" href="<?= $moreLink ?>">
                <h3><?= $title ?></h3>
            </a>
            <div class="content"> <?= $text; ?> </div>

            <a href="<?= $moreLink ?>" class="btn animated-underline">
                <?= __('Mehr erfahren','pol'); ?>
            </a>
        </div>
    </article>

    <?php

}

function addBlogTeaser(){
    ?>
    <div class="blog-post-teaser">
        <a class="no-underline" href="<?= get_the_permalink(); ?>">
            <h2><?= get_the_title(); ?></h2>
        </a>
        <div class="subtitle">
            <?php
            $date = get_post_time('d F Y',false,null,true);
            $author = get_the_author();
            echo sprintf(__('Gepostet am %s von %s','pol'),$date,$author);
            ?>
        </div>

        <a class="no-underline" href="<?= get_the_permalink(); ?>">
            <img src="<?= getThumbnailInSize('large'); ?>" alt="<?= get_the_title(); ?>" class="post-img">
        </a>

        <div class="excerpt">
            <?= get_the_excerpt(); ?>
        </div>
        <a href="<?= get_the_permalink(); ?>" class="read-more animated-underline">
            <?= __('Mehr lesen','pol') ?>
        </a>
    </div>
    <?php
}