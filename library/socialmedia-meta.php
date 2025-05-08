<?php
/**
 * Code generating default meta tags for social media.
 * Use Filters defined here to override this behaviour
 * User: shaboom
 * Date: 30/09/17
 * Time: 11:53
 */

function getSocialMediaMetaTags(){

    $tags = ['og:title' => '',
             'og:site_name' => get_field('field_default_seo_facebook_sitename','option'),
             'og:description' => '',
             'og:image' => '',
             'og:url' => get_the_permalink(),
             'og:type' => 'website',
             'og:locale' => apply_filters( 'wpml_active_languages', NULL ),
             'twitter:card' => 'summary',
             'twitter:description' => '',
             'twitter:image' => ''
    ];

    //Apply filter to give each object the ability to insert its own meta tags.
    $tags = apply_filters('filter_social_metatags',$tags);

    //Tags that provide default values and are not set after the filter by the objects itself
    //will fallback to their default behaviour

    //IMAGE - explicit setting -> thumbnail -> option settings
    if(empty($tags['og:image']) ||empty($tags['twitter:image'])){
        
        //explicit settings
        $si = get_field('field_seo_social_image'); $si = $si ? $si['sizes']['large'] : null;
        
        //thumbnail 
        if(!$si) $si = getThumbnailInSize('large');
            
        //option setting
        if(!$si){
            $si = get_field('field_default_seo_social_image','option');
            $si = $si ? $si['sizes']['large'] : null;
        }   
        
        $tags['og:image'] = $tags['twitter:image'] = $si;
    }
    

    //TITLE - explicit setting -> post_title
    if(empty($tags['og:title'])){
        //explicit settings
        $st = get_field('field_seo_social_title');
        //post_title
        if(empty($st)) $st = get_the_title() . get_field('field_default_seo_social_title_appendix','option');
        
        $tags['og:title'] = $st;
    } 
    
    //DESCRIPTION - explicit setting -> option setting

    if(empty($tags['og:description']) ||empty($tags['twitter:description'])){
        //explicit setting
        $sd = get_field('field_seo_social_description');
        //option setting
        if(empty($sd)) $sd = get_field('field_default_seo_social_description','option');
        
        $tags['og:description'] = $tags['twitter:description'] = $sd;
    }
    
    //Remove all empty or null elements
    $tags = array_filter($tags);

    return $tags;
}
