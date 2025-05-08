<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

$pageTemplate = is_home() ? 'index' : basename(get_page_template());
$isDev = isDev();

?>
<link rel="stylesheet" href="https://use.typekit.net/fua2gis.css">

<!doctype html>
<html id="page-html" data-toggler="popup-open" class="no-js" <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php wp_head(); ?>

        <?php
        //Meta TAGS
        //trace some meta field values that might be set.

      $metaValues = ['description','keywords','revisit'];
        foreach ($metaValues as $mv){
            $val = get_field('field_seo_meta_tag_'. $mv);
            if(!$val) $val = get_field('field_default_seo_meta_tag_'. $mv, 'option');
            if($val) { ?><meta name="<?= $mv  ?>" content="<?= $val; ?>"><?php }
        }

        ?>

        <?php
        //Social Tags
        $st = getSocialMediaMetaTags();
        foreach ($st as $tagName => $tagValue ){
            ?><meta property="<?= $tagName;  ?>" content="<?= $tagValue  ?>"><?php
        }
        ?>


    </head>
    <body <?php body_class( $isDev ? 'devmode' : '' ); ?> page-template="<?= $pageTemplate; ?>" post-type="<?= get_post_type(); ?>">

    <?php
    if($isDev){ //will display the breakpoint at the bottom of the screen
        ?>
        <aside class="breakpoints">
            <div class="bp-debug show-for-small-only"> Small </div>
            <div class="bp-debug show-for-medium-only"> Medium </div>
            <div class="bp-debug show-for-large"> Large </div>
        </aside>
        <?php
    }
    ?>

    <nav class="menu-font z5">
        <div class="logo">
            <a class="no-underline" href="<?= get_bloginfo('url'); ?>">
                <?= getACFImgTag(get_field('logo','option'),false,'','medium'); ?>
            </a>
        </div>
        <div class="desktop show-for-large">
            <div class="container">
                <?= wp_nav_menu(['theme_location' => 'top-bar-r']); ?>
            </div>
        </div>
        <div class="mobile hide-for-large">
            <div id="mobile-menu-close-btn" class="hidden menubtn" data-toggler="hidden" data-toggle="mobile-menu mobile-menu-open-btn mobile-menu-close-btn"></div>
            <div id="mobile-menu-open-btn"  class="menubtn" data-toggler="hidden" data-toggle="mobile-menu mobile-menu-open-btn mobile-menu-close-btn"></div>
            <div id="mobile-menu" class="hidden" data-toggler="hidden" popup>
                <?= wp_nav_menu(['theme_location' => 'mobile-nav']); ?>
            </div>
        </div>
    </nav>



    <main class="container">
