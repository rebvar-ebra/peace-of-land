<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

?>

		</main>
<footer>

    <?=  wp_nav_menu(['theme_location' => 'footer', 'container_class' => 'footer-menu-container']); ?>

    <?php
    if(isDev()){
        ?>
        <script id="__bs_script__">//<![CDATA[
            document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.7'><\/script>".replace("HOST", location.hostname));
            //]]></script>
    <?php
    }
    ?>

    <?php wp_footer(); ?>
</footer>
</body>
</html>
