<?php
/**
 * Enqueue all styles and scripts
 *
 * Learn more about enqueue_script: {@link https://codex.wordpress.org/Function_Reference/wp_enqueue_script}
 * Learn more about enqueue_style: {@link https://codex.wordpress.org/Function_Reference/wp_enqueue_style }
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

function enqueueScripts() {

    $ver = "1.0.21"; //Quick variable to bump up the version on new commits.

    /*STYLE SHEETS*/
    // Enqueue the main Stylesheet.
    wp_enqueue_style( 'main-stylesheet', get_template_directory_uri() . '/assets/css/theme.css', array(), $ver, 'all' );


    //Deregister the jquery version bundled with WordPress - we precompile with JQuery
    wp_deregister_script( 'jquery' );

    wp_enqueue_script( 'theme', get_template_directory_uri() . '/assets/js/app.js',[], $ver, true );
    wp_enqueue_script( 'libs', get_template_directory_uri() . '/assets/js/libs.js',[], $ver, true );

    //Map ajax requests to admin, so that they can be accessed via filters.
    wp_localize_script( 'theme', 'Ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

}

function enqueueAdminScripts(){
    /*STYLE SHEETS*/
    // Enqueue the main Stylesheet.
    wp_enqueue_style( 'admin-stylesheet', get_template_directory_uri() . '/assets/css/theme_admin.css', array(), "1.0.0", 'all' );
?>


    <?php
}

add_action( 'wp_enqueue_scripts', 'enqueueScripts' );
add_action( 'admin_enqueue_scripts', 'enqueueAdminScripts' );

