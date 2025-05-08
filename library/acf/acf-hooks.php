<?php

//Filter to set the title of collapsed Flexible content fields in conjunction with the acf fields builder by stoutLogic 
//for it allows to add custom properties to each ACF object. 

//to use it add the property title_field in the flexible content args.
//->addFlexibleContent('examples', ['title_field' => ['example' => 'object_name']])
//if for all Layouts the field is the same (since all contain that field), just use a string instead of an array
//->addFlexibleContent('examples', ['title_field' => 'title'])

//add an entry where the keys are the layout names, and the values are the name of the subfields inside the respective layouts.
//The values of these fields will be used as titles for the respective flexible content field when collapsed. Updates on collapse of the field.
 
function changeLayoutTitle( $title, $field, $layout, $i ) {

    if(!isset($field['title_field'])) return $title;

    //if the layout name is "Text Input" the key in ACF will be "text_input" we take care of this manually.
    $l = strtolower(str_replace(' ', '_', $layout['name']));

    //on first run get_sub_field is unavailable but the data can be read directly from value array,
    //on ajax calls field is available but value array is not. we take care of both cases
    if($field['value'] === null){ //consecutive AJAX runs 
        if(null !== get_row_layout()){
            $sfName = $field['title_field'];
            if(is_array($field['title_field']))
                $sfName = $field['title_field'][$l];

            if(get_sub_field($sfName))
                return $layout['label'] . ': ' . get_sub_field($sfName);

            return $title;
        }
    }else if(is_numeric($i)){ //first run 
        if(is_array($field['title_field']))
            return $layout['label'] . ': ' . $field['value'][$i][$field['key'] .'_'. $l.'_'.$field['title_field'][$l]];
        else
            return $layout['label'] . ': ' . $field['value'][$i][$field['key'] .'_'. $l.'_'.$field['title_field']];
    }

    return $title;
}

// name
add_filter('acf/fields/flexible_content/layout_title', 'changeLayoutTitle', 10, 4);



function convertStarsToStrongs( $value, $post_id, $field ) {
    return preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $value);
}

//Add names of fields where it is desired to convert a ** wrapping into <strong> wrapping.

add_filter('acf/load_value/name=mission_statement', 'convertStarsToStrongs', 10, 3);


function dateTimeToTimestamp( $value, $post_id, $field ) {
    $value = strtotime(str_replace('/','-',$value));
    return $value;
}
// acf/load_value/type={$field_type} - filter for a value load based on it's field type
add_filter('acf/load_value/type=date_time_picker', 'dateTimeToTimestamp', 10, 3);


//Allow inactive projects to be linked.
add_filter('acf/fields/post_object/query', 'relationship_options_filter', 10, 3);
function relationship_options_filter($options, $field, $the_post) {
    $options['post_status'] = ['publish','inactive'];
    return $options;
}