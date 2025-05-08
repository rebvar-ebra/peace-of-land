<?php
/**
 * Created by PhpStorm.
 * User: shaboom
 * Date: 30/05/17
 * Time: 13:16
 */

function runEmailShortcode($atts, $content){

    //Inline HTML returned example
    ob_start();
    ?>
    <div class="mailing-link">
        <a  class="no-underline" href="mailto:<?=$content ?>"><?= $content ?></a>
    </div>
    <?php
    return ob_get_clean();

}

add_shortcode('email','runEmailShortcode');