<?php
/**
 * Author: Ilya Shabanov
 * URL: http://ilya.sh
 *
 * FoundationPress functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */



add_filter('uf_enqueue_scripts',function(){return ['theme','libs'];});
//Localization
load_theme_textdomain( 'pol', get_template_directory() . '/languages' );



/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Some Settings for social media tags */
require_once( 'library/socialmedia-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

require_once( 'library/util.php' );

/*Shortcodes example*/
require_once( 'library/shortcodes.php' );

/*Layout Parts*/
require_once( 'library/parts/layout.php' );

/*External libs*/
//require_once( 'library/_external/Inflector.php' );
require_once( 'library/acfbuilder/autoload.php' );
require_once( 'library/_external/wp-custom-post-type-class/CPT.php' );

/*ACF in Code*/
require_once( 'library/acf/acf-hooks.php' );
require_once( 'library/acf/acf-templates.php' );
require_once( 'library/acf/acf-options.php' );
require_once( 'library/acf/acf-posttypes.php' );

/*Posttypes*/
require_once( 'library/posttypes.php' );

/*Menus*/
require_once( 'library/admin-menus.php' );


require_once( 'library/admincols.php' );
require_once( 'library/_external/ICS.php' );
require_once( 'library/admin.php' );
require_once( 'library/mailchimp.php' );


/** If your site requires protocol relative url's for theme assets, uncomment the line below */
// require_once( 'library/protocol-relative-theme-assets.php' );


//***************************************************************/
//* AJAX */
//***************************************************************/

require_once( 'library/ajax/ical.php' );
require_once( 'library/ajax/posts-query.php' );


//***************************************************************/
//* GOOGLE MAPS */
//***************************************************************/


//For google maps to work the api key is required.
function my_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyDIdTV7nilo2y2ozEQ51NM3vdahp-xFfJQ');
}

add_action('acf/init', 'my_acf_init');


