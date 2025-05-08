<?php
/**
 * Advanced Custom Fields Definition for Page Templates go here.
 * User: shaboom
 * Date: 31/07/17
 * Time: 17:18
 */


use StoutLogic\AcfBuilder\FieldsBuilder;


//***************************************************************/
//* HELPERS */
//***************************************************************/

//Wrapper classes to split in 2,3,4 columns
$w2 = ['width' => '50']; $w2f = ['wrapper' => $w2];
$w3 = ['width' => '33']; $w3f = ['wrapper' => $w3];
$w4 = ['width' => '25']; $w4f = ['wrapper' => $w4];

//***************************************************************/
//* GENERIC */
//***************************************************************/

$gen = new FieldsBuilder('generic');
$gen->addImage('header_icon')
    ->setLocation('page_template', '!=', 'page-templates/page-front.php')
    ->and('post_type', '==', 'page');

//***************************************************************/
//* ABOUT US */
//***************************************************************/

$about = new FieldsBuilder('about');
$about->addImage('main_img')
    ->addWysiwyg('front_text')
    ->addWysiwyg('bottom_text')
    ->setLocation('page_template', '==', 'page-templates/page-about.php');

//***************************************************************/
//* LIBRARY */
//***************************************************************/

$library = new FieldsBuilder('library');
$library
    ->addTextarea('infos_and_contact',['new_lines' => 'br'])
    ->addRelationship('people',['post_type' => 'mitglieder'])
    ->setLocation('page_template', '==', 'page-templates/page-library.php');

//***************************************************************/
//* PROJECTS */
//***************************************************************/

$projects = new FieldsBuilder('projects');
$projects->addImage('map',['preview_size' => 'large'])
    ->addRepeater('spots')
        ->addImage('icon')
        ->addText('pos',['instructions' => 'A position in percent from top left. e.g. "30/40" would be the 30% of the left side and 40% of the top of the image.'])
        ->addText('tooltip')
        ->addPostObject('project',['post_type' => 'projekte'])
    ->endRepeater()
    ->setLocation('page_template', '==', 'page-templates/page-projects.php');

//***************************************************************/
//* CONTACT */
//***************************************************************/

$contact = new FieldsBuilder('contact');
$contact
        ->addPostObject('contact_form',['wrapper'=>$w2,'post_type' => 'uber_form','instructions' => 'Use the shortcode [form] inside the content to display.'])
        ->addPostObject('newsletter_form',['wrapper'=>$w2, 'post_type' => 'uber_form','instructions' => 'Use the shortcode [newsletter] inside the content to display.'])
        ->addGallery('icons',['wrapper'=>$w2,'instructions' => 'Use shortcodes [img 1]Link[/img] to acces the first icon in this set, use img 2, img 3 accordingly. Shortcode can have optional width, height and offset parameters: [img 2 w="20" h="25" o="-3"].'])
        ->addGoogleMap('map',['wrapper'=>$w2,'instructions' => 'Use the shortcode [map] inside the content to display.'])
        ->addWysiwyg('sidebar_content')

    ->setLocation('page_template', '==', 'page-templates/page-contact.php');

//***************************************************************/
//* FRONT PAGE */
//***************************************************************/

$front = new FieldsBuilder('front');
$front->addTab('Header')
            ->addText('tagline')
            ->addImage('header_img')
        ->addTab('Mission')
            ->addTextArea('mission_statement')
            ->addLink('mission_button',$w2f)
            ->addImage('mission_icon',$w2f)
        ->addTab('Events')
            ->addText('events_title',$w3f)
            ->addText('events_sub_title',$w3f)
            ->addLink('events_button',$w3f)
            ->addRelationship('events',['post_type' => 'veranstaltungen', 'filters'=> ['search'],'instructions'=>'Optional, wenn leer werden die neuesten geladen.'])
        ->addTab('Projects')
            ->addText('projects_title',$w3f)
            ->addText('projects_sub_title',$w3f)
            ->addLink('projects_button',$w3f)
            ->addRelationship('projects',['post_type' => 'projekte', 'filters'=> ['search'],'instructions'=>'Optional, wenn leer werden die letzten geladen.'])
        ->addTab('People')
            ->addText('people_title',$w3f)
            ->addText('people_sub_title',$w3f)
            ->addLink('people_button',$w3f)
            ->addRelationship('people',['post_type' => 'mitglieder', 'filters'=> ['search'], 'instructions'=>'Optional, wenn leer werden zufällige geladen.'])
        ->addTab('Support')
            ->addText('support_title',$w2f)
            ->addText('support_sub_title',$w2f)
            ->addGallery('support_logos')
        ->setLocation('page_template', '==', 'page-templates/page-front.php');

add_action('acf/init', function() use ($front,$contact, $gen,$about, $projects, $library) {
    acf_add_local_field_group($projects->build());
    acf_add_local_field_group($library->build());
    acf_add_local_field_group($contact->build());
    acf_add_local_field_group($about->build());
    acf_add_local_field_group($front->build());
    acf_add_local_field_group($gen->build());
});
