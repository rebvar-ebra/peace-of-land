<?php
/**
 * Created by PhpStorm.
 * User: artifex
 * Date: 30.11.17
 * Time: 19:27
 */

add_action('uf_form_submission_success','sendToMailchimp',10);
function sendToMailchimp($formData){

    //Get the interest mappings
    $formMappings = get_field('form_mapping','option');

    $list_id = null;
    foreach ($formMappings as $fm){
        if($fm['form']->ID == intval($formData['id'])){ //found the correct form mapping
            $list_id = $fm['list_id'];
            break;
        }
    }


    if(!$list_id){
        UF_Plugin::appendDebugToCurrentFormProcessing('Mailchimp error. No List mapping defined in the theme settings for current form.');
        return;
    }

    $mergeFields = [];
    while(have_rows('mailchimp_mapping','option')){
        the_row();
        if(isset($_POST[get_sub_field('id_in_form')])){
            $mergeFields[get_sub_field('fieldname_in_mailchimp')] = $_POST[get_sub_field('id_in_form')];
        }
    }

    $mailchimp = new MC4WP_MailChimp();

    $update_existing = true;
    $replace_interests = true;

//    UF_Plugin::appendDebugToCurrentFormProcessing('MC: Fname: ' . $formData[$mappings['FNAME']] . ' mapping: ' . $mappings['FNAME'] );

    $userMail = $formData[get_field('field_mailchimp_user_email_form_field','option')];

    $mc_args = [
        'email_address' => $userMail,
        'interests' => [],
        'merge_fields' => $mergeFields,
        'status' => 'pending',
        'email_type' => 'html',
        'ip_signup' => '127.0.0.1'
    ];

//    UF_Plugin::appendDebugToCurrentFormProcessing('mailchimp args: ' . $mc_args['merge_fields']['FNAME'] . ' -- ' . $mc_args['merge_fields']['LNAME']);

    $result = $mailchimp->list_subscribe( $list_id,
        $userMail,
        $mc_args,
        $update_existing,
        $replace_interests );

    if(!$result){
        UF_Plugin::appendDebugToCurrentFormProcessing('Mailchimp error('.$mailchimp->error_code.': '.$mailchimp->error_message->title.'): ' . $mailchimp->error_message->detail);
    }else{
        UF_Plugin::appendDebugToCurrentFormProcessing('Mailchimp success: Added ' . $mc_args['email_address'] . ' successfully to list: ' . $list_id . ' into interests: ' . implode(',',array_keys($interestsGroups)) . ' Double Optin: ' . ($doubleOptin ? 'yes' : 'no'));
    }

}