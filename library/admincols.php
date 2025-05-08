<?php
/**
 * Created by PhpStorm.
 * User: artifex
 * Date: 13.11.18
 * Time: 10:58
 */

function _fixed_count($array_obj){
  if(!is_array($array_obj)){
    $array_obj = (array) $array_obj;
  }
  try{
    return count($array_obj);
  } catch(Exception $exc){ //for laravel add back slash \ before Exception eg: (\Exception)
    return 0;
  }
}

class AdminCols{
    private $post_type;
    private $cols;

    public function __construct($forType) {
        $this->post_type = $forType;

        add_filter( 'manage_'.$forType.'_posts_columns', [&$this,'addColumns'] );
        add_filter( 'manage_'.$forType.'_posts_custom_column', [&$this,'populateColumns'], 10, 2 );
    }

    public function addCustomColumn($colTitle, $formatter, $slug= null) {
        $this->cols[] = ['slug'=>($slug ? $slug : 'custom_col_'._fixed_count($this->cols)),'type' => 'custom', 'title'=> $colTitle, 'formatter' => $formatter ];
    }
    public function addACFColumn($colTitle, $acfName, $slug= null) {
        $this->cols[] = ['slug'=>($slug ? $slug : 'custom_col_'._fixed_count($this->cols)),'type' => 'acf', 'title'=> $colTitle, 'field' => $acfName , 'formatter' => null ];
    }
    public function addThumbColumn($colTitle, $maxH, $slug= null) {
        $this->cols[] = ['slug'=>($slug ? $slug : 'custom_col_'._fixed_count($this->cols)),'type' => 'thumb', 'title'=> $colTitle, 'height' => $maxH];
    }


    public function addColumns($columns) {
        foreach ($this->cols as $c) $columns[$c['slug']] = $c['title'];
        return $columns;
    }

    public function populateColumns($column, $post_id) {
        foreach ($this->cols as $c){
            if($c['slug'] == $column){
                switch ($c['type']){
                    case 'custom':
                        echo call_user_func_array($c['formatter'], [$column, $post_id]);
                        break;
                    case 'acf':
                        echo get_field($c['field'],$post_id);
                        break;
                    case 'thumb':
                        $url = getThumbnailInSize('medium',$post_id);
                        $h = $c['height'] . 'px';
                        echo "<img src='${url}' style='max-height:${h}'>";
                        break;
                }
            }
        }
    }
}