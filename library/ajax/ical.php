<?php
/**
 * Created by PhpStorm.
 * User: shabananda
 * Date: 12.05.17
 * Time: 11:21
 *
 * To integrate Form use following demo markup:
 *
 * <form id="join-nl-form" data-abide>
		<input id="nl-name" type="text" name="name" placeholder="Your Name..." value="Ilya"/>
		<input id="nl-email" type="email" name="email" placeholder="Your Email..." value="me@ilya.sh"/>
		<button class="black" type="submit">Submit</button>
	</form>
 *
 */

//function for service handling
function runICalService(){

    header('Content-Type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$_POST['summary'].'.ics');

    require '../_external/ICS.php';
    $ics = new ICS($_POST);

    echo $ics->to_string();
	exit;
}

if(isset($_POST['eid'])) runICalService();