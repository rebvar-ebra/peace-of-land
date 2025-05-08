<?php
/**
 * Custom Post Type Defintions go here. 
 * User: shaboom
 * Date: 28/09/17
 * Time: 18:47
 */


//***************************************************************/
//* Example Post Type */
//***************************************************************/

//This is the minimal init with CPT class, localizations of the post type have to be defined in the strings inside CPT class,
//which simply uses singualr and plural strings passed here to create the "add new xy" etc strings
new CPT( ['post_type_name' => __('Mitglieder','pol'),
                    'slug' => 'mitglied',
                    'singular' => __('Mitglied','pol'),
                    'plural' => __('Mitglieder','pol')],

                  ['supports' => array('title','editor','thumbnail','excerpt'), 'menu_icon' => 'dashicons-id'  ]);

new CPT( ['post_type_name' => __('Projekte','pol'),
                    'slug' => 'projekt',
                    'singular' => __('Projekt','pol'),
                    'plural' => __('Projekte','pol')],

                  ['supports' => array('title','editor','thumbnail','excerpt'), 'menu_icon' => 'dashicons-hammer'  ]);

$books = new CPT( ['post_type_name' => __('Buecher','pol'),
                    'slug' => 'buch',
                    'singular' => __('Buch','pol'),
                    'plural' => __('Bücher','pol')],
                  ['supports' => array('title','editor','thumbnail','excerpt'), 'menu_icon' => 'dashicons-book']);

$books->register_taxonomy(array('taxonomy_name' => 'bookcat',
    'singular' => 'Buchkategorie',
    'plural' => 'Buchkategorien',
    'slug' => 'bookcat'));

$evts= new CPT( ['post_type_name' => __('Veranstaltungen','pol'),
                    'slug' => 'veranstaltung',
                    'singular' => __('Veranstaltung','pol'),
                    'plural' => __('Veranstaltungen','pol')],

                  ['supports' => array('title','editor','thumbnail','excerpt'), 'menu_icon' => 'dashicons-calendar-alt'  ]);

$evts->register_taxonomy(array('taxonomy_name' => 'type',
    'singular' => 'Veranstaltungsart',
    'plural' => 'Veranstaltungsarten',
    'slug' => 'type'));

//make sure
add_action('add_meta_boxes','addPolMetaBoxes',10,2);
function addPolMetaBoxes($post_type, $post) {
    if($post_type != 'veranstaltungen') return;
    ob_start();
}
add_action('dbx_post_sidebar','clearPolMetaBoxes');
function clearPolMetaBoxes() {
    if(get_post_type() != 'veranstaltungen') return;

    $html = ob_get_clean();
    $html = preg_replace('/type="checkbox"(.*name="tax_input\[type\])/', 'type="radio" $1', $html);
    echo $html;
}

