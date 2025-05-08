<?php
/**
 * Needed by WP
 * User: artifex
 * Date: 09.10.18
 * Time: 14:04
 */




function addCurMonthSelector( $link_html ) {
    $mnum = get_query_var('monthnum');
    if(strlen($mnum) == 1) $mnum = '0'.$mnum;
    preg_match('/href=\'.*'.get_query_var('year').'\/'.$mnum.'/', $link_html, $out);
    if(!empty($out))
        $link_html = preg_replace('/<li>/i', '<li class="current-month">', $link_html );
    return $link_html;
}

add_filter( 'get_archives_link', 'addCurMonthSelector' );

?>

<aside class="sidebar">

    <div class="sidebar-box-transparent list">
        <div class="title"> <?= __('Kategorien','pol');?> </div>

        <ul>
            <?= wp_list_categories('title_li=');?>
        </ul>
    </div>

    <div class="sidebar-box-transparent list">
        <div class="title"> <?= __('Archiv','pol');?> </div>

        <ul>
            <?php
                wp_get_archives(['type'=>'monthly'])
            ?>
        </ul>
    </div>


</aside>

<?php remove_filter( 'get_archives_link', 'addCurMonthSelector' ); ?>
