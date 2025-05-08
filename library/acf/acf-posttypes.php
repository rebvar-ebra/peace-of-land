<?php
/**
 * Advanced Custom Fields Definition for Post Types go here.
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
//* SEO overrides */
//***************************************************************/

$seo = new FieldsBuilder('seo');
$seo->addTab('Meta Tags')
    ->addText('meta_tag_description',['instructions' => 'Meta Tags for name="description".'])
    ->addText('meta_tag_keywords',['instructions' => 'Meta Tags for name="keywords".'])
    ->addText('meta_tag_revisit',['instructions' => 'Meta Tags for name="revisit".'])
    ->addTab('Social')
    ->addText('social_title',['wrapper'=>$w2,'instructions' => 'Overrides og:title and twitter:title defined programmatically (usually the page\'s title)' ])
    ->addImage('social_image',['wrapper'=>$w2,'instructions' => 'Overrides og:image defined programmatically or in options. (usually the page\'s thumbnail)'])
    ->addTextArea('social_description',['instructions' => 'Overrides og:description defined programmatically or in options. (usually the page\'s excerpt)'])
    ->setLocation('post_type', '==', 'post')
    ->or('post_type', '==', 'page');

//***************************************************************/
//* People */
//***************************************************************/

$member = new FieldsBuilder('member');
$member->addText('email')
       ->setLocation('post_type', '==', 'mitglieder');

//***************************************************************/
//* BOOKS */
//***************************************************************/
$b = new FieldsBuilder('book');
$b->addText('subtitle',$w2f)
  ->addSelect('status',['choices' => ['available' => 'Verfügbar', 'rented' => 'Entliehen'],'default_value' => 'available','wrapper' => $w2])
  ->addRelationship('people',['post_type' => 'mitglieder', 'filters'=> ['search'],'wrapper' => $w2])
   ->setLocation('post_type', '==', 'buecher');

//***************************************************************/
//* Projects */
//***************************************************************/

$projects = new FieldsBuilder('project');
$projects
        ->addTrueFalse('inactive',['message' => 'Project is inactive', 'wrapper' => $w3])
        ->addTrueFalse('links_to_page',['message' => 'Links to page', 'wrapper' => $w3])
        ->addPageLink('linked_page',['wrapper'=>$w3,'post_type'=>'page'])->conditional('links_to_page','==','1')
        ->addImage('icon',$w2f)
        ->addText('short_title',['wrapper'=>$w2,'instructions' => 'Appears on frontpage if set.'])
        ->addTextarea('teaser',['instructions' => 'Appears on the all Projects page.'])
        ->addRelationship('people',['post_type' => 'mitglieder', 'filters'=> ['search'],'wrapper' => $w2])->conditional('links_to_page','==','0')
        ->addRelationship('people_organizers',['post_type' => 'mitglieder', 'filters'=> ['search'],'wrapper' => $w2])->conditional('links_to_page','==','0')
         ->addRelationship('events',['post_type' => 'veranstaltungen', 'filters'=> ['search']])->conditional('links_to_page','==','0')
         ->addTextarea('date_and_time',['wrapper' => $w3, 'new_lines'=>'br'])->conditional('links_to_page','==','0')
         ->addTextarea('location',['wrapper' => $w3, 'new_lines'=>'br'])->conditional('links_to_page','==','0')
         ->addTextarea('infos',['wrapper' => $w3, 'new_lines'=>'br'])->conditional('links_to_page','==','0')
       ->setLocation('post_type', '==', 'projekte');

//***************************************************************/
//* EVENTS */
//***************************************************************/

$events= new FieldsBuilder('events');

$events ->addText('short_title',['wrapper'=>$w2,'instruction'=>'Appears in sidebars and frontpage if set.'])
        ->addTextarea('teaser',['instructions' => 'Appears on the all Events page.'])
        ->addRelationship('people',['post_type' => 'mitglieder', 'filters'=> ['search'],'wrapper' => $w2])
        ->addRelationship('people_organizers',['post_type' => 'mitglieder', 'filters'=> ['search'],'wrapper' => $w2])
         ->addTextarea('location',['wrapper' => $w3, 'new_lines' => 'br'])
         ->addTextarea('infos',['wrapper' => $w3, 'new_lines' => 'br'])
         ->addTextarea('costs',['wrapper' => $w3, 'new_lines' => 'br'])
         ->addLink('booking_link',$w3f)
         ->addDateTimePicker('start_date',$w3f)
         ->addDateTimePicker('end_date',$w3f)
       ->setLocation('post_type', '==', 'veranstaltungen');

$event_type = new FieldsBuilder('event_type');
$event_type->addImage('img',$w2f)
           ->addColorPicker('color',$w2f)
           ->setLocation('taxonomy','==','type');

/** ------------------------------------------------------------- */
add_action('acf/init', function() use ($seo, $member,$b,$projects,$events,$event_type) {
    acf_add_local_field_group($seo->build());
    acf_add_local_field_group($member->build());
    acf_add_local_field_group($b->build());
    acf_add_local_field_group($projects->build());
    acf_add_local_field_group($events->build());
    acf_add_local_field_group($event_type->build());
});
