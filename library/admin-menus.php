<?php
/**
 * Created by PhpStorm.
 * User: artifex
 * Date: 29.11.17
 * Time: 13:34
 */



add_action('acf/init', function(){

    //OPTIONS PAGE
    acf_add_options_page(array(
        'page_title' 	=> 'General',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'pol-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false,
        'position'      => 10,
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'SEO',
        'menu_title'	=> 'SEO Settings',
        'parent_slug'	=> 'pol-general-settings'
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Mailchimp',
        'menu_title'	=> 'Mailchimp Settings',
        'parent_slug'	=> 'pol-general-settings'
    ));

});