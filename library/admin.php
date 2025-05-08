<?php
/**
 * Created by PhpStorm.
 * User: artifex
 * Date: 01.11.18
 * Time: 18:04
 */


//***************************************************************/
//* POST STATE FOR PROJECTS TABLE*/
//***************************************************************/

$acProjects = new AdminCols('projekte');
$acProjects->addCustomColumn(__( 'Status', 'pol' ),function($col, $pid){
    return get_field('inactive',$pid) ? __('Inaktiv','pol') : __('Aktiv','pol');
});

$acEvents = new AdminCols('veranstaltungen');
$acEvents->addCustomColumn(__( 'Zeit', 'pol' ),function($col, $pid){
    $s = get_field('start_date', $pid,false);
    $e = get_field('end_date', $pid,false);
    if(empty($s)) return 'Startdatum fehlt!';
    else if(empty($e)) return 'Enddatum fehlt!';
    else{
        $r = date('d M. Y G:i', $s);
        if(date('d', $s)==date('d',$e)){ //event on single day
            $r .= ' bis ' . date('G:i',$e);
        }else{
            $r .= ' bis ' . date('d M. Y G:i',$e);
        }
        return $r;
    }
    return 'Fehler';
});

$acBooks = new AdminCols('buecher');
$acBooks->addACFColumn(__('Subtitle','pol'),'subtitle');
$acBooks->addACFColumn(__('Status','pol'),'status');
$acBooks->addThumbColumn(__('Bild','pol'),60);
