<?php
/**
 * Advanced Custom Fields Definition for Option Pages go here.
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
//* SEO as Example*/
//***************************************************************/

$seo = new FieldsBuilder('default_seo');
$seo->addTab('Meta Tags')
        ->addText('meta_tag_description',['instructions' => 'Default Meta Tags for name="description". May be overwritten by editing the post itself.'])
        ->addText('meta_tag_keywords',['instructions' => 'Default Meta Tags for name="kewords". May be overwritten by editing the post itself.'])
        ->addText('meta_tag_revisit',['instructions' => 'Default Meta Tags for name="revisit". May be overwritten by editing the post itself.'])
    ->addTab('Social')
        ->addText('facebook_sitename',['wrapper'=>$w2,'instructions' => 'The og:site_name that will appear on all pages'])
        ->addImage('social_image',['wrapper'=>$w2,'instructions' => 'Fallback for og:image and twitter:image if page does not provide its own and does not define programmatically.'])
        ->addTextArea('social_description',['instructions' => 'Fallback for og:description and twitter:description if page does not provide its own and does not define programmatically.'])
        ->addText('social_title_appendix',['instructions' => 'A String appended to the post_title if the title setting is not set explicitely.'])
    ->setLocation('options_page', '==', 'acf-options-seo-settings');

$theme = new FieldsBuilder('theme');
$theme->addTab('General')
        ->addImage('logo',['instructions'=>'Appears in the menu.'])
        ->addPageLink('people_page',['wrapper' =>$w4, 'post_type'=>'page'])
        ->addPageLink('projects_page',['wrapper' =>$w4, 'post_type'=>'page'])
        ->addPageLink('events_page',['wrapper' =>$w4, 'post_type'=>'page'])
        ->addPostObject('blog_page',['wrapper' =>$w4, 'post_type'=>'page'])
    ->addTab('Blog')
        ->addNumber('blogposts_per_page',['default_value' => 3])

    ->setLocation('options_page', '==', 'pol-general-settings');

//***************************************************************/
//* MAILCHIMP */
//***************************************************************/


$mc = new FieldsBuilder('mailchimp');

$mc->addMessage('Forms Mapping','The fieldmapping maps the forms on the website to mailchimp lists. If no mapping is provided the form will not send to mailchimp.')
    ->addRepeater('form_mapping')
    ->addPostObject('form',['post_type'=>'uber_form'])
    ->addText('list_id')
    ->endRepeater()
    ->addMessage('Fields Mapping','The fieldmapping maps the name of the form fields to mailchimp. The form fields are set in the forms themselves.')
    ->addRepeater('mailchimp_mapping')
    ->addText('id_in_form')
    ->addText('fieldname_in_mailchimp')
    ->endRepeater()
    ->addText('user_email_form_field')
    ->setLocation('options_page', '==', 'acf-options-mailchimp-settings');


add_action('acf/init', function() use ($seo,$theme, $mc) {
    acf_add_local_field_group($seo->build());
    acf_add_local_field_group($theme->build());
    acf_add_local_field_group($mc->build());
});
