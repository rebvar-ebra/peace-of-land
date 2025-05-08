<?php
/**
 * All kinds of useful functions for theme
 * User: shabananda
 * Date: 26/12/2016
 */



class ResponsiveSizeSetting{

    protected $sizesToUse;
    protected $widthOnScreen;

    /**
     * ResponsiveSetting constructor. A utitily class to generate responsive sourcesets from WP images.
     * @param $sizesToUse an array of sizes to be embedded into the srcset like ['url','large','medium']. Smallest should go last.
     * @param $widthOnScreen the width this image will take con screen like 50vw for an img that takes 50% of viewportwidth
     */
    public function __construct($sizesToUse, $widthOnScreen="100vw"){
        $this->widthOnScreen  = $widthOnScreen;
        $this->sizesToUse  = $sizesToUse;
    }

    public function getSizesSet($intoAttribute='sizes') {
        if(!empty($intoAttribute)){
            return ' '.$intoAttribute.'="'.$this->widthOnScreen.'" ';
        }
        return $this->widthOnScreen;
    }
    public function getSrc($acfData, $intoAttribute = 'src') {

    }
    public function getSrces($acfData, $srcsetAttribute = 'srcset', $srcAttribute = 'src') {
        $s = [];

        foreach ($this->sizesToUse as $size){
            if($size == 'url'){
                array_push($s,$acfData[$size] .'____'.$acfData['width'].'w');
            }else{
                array_push($s,$acfData['sizes'][$size] .'____'.$acfData['sizes'][$size.'-width'].'w');
            }
        }

        $first = $s[0]; //first attribute goes into src, not src set - fix for IE not supporting srcset
        $first = substr($first,0,strpos($first,'____'));
        $res = ' ' . $srcsetAttribute .'="' . str_replace('____',' ',implode(', ',$s)) . '" ';
        $res .= ' ' . $srcAttribute .'="' . $first . '" ';

        return $res;
    }
}


//***************************************************************/
//* IMAGE RELATED */
//***************************************************************/

/**
 * Returns an html-img tag that will be lazy loaded.
 * @param $img The return from get_field in ACF
 * @param $lazy If true, image will be lazy loaded. Default is true.
 * @param string $class Optional additional classes to add to the img.
 * @param string $size An optional size to use. Default is 'url' which is original size, sizes are wordpress sizes like "large" or "medium"
 * For responsive images pass an instance of ResponsiveSetting to include srcset and such
 * @param string $atts An optional string that will be added into the tag like 'data-toggle="pageBody"' for example.
 * @return string img HTML node.
 */
function getThumbImgTag($forPost = null , $lazy = true, $class = '', $size = 'url', $atts = ''){
    $pid = get_post_thumbnail_id($forPost);
    $alt = $forPost ? acf_get_post_title($forPost) : '';
    $img = wp_get_attachment_image_src($pid,$size)[0];
    if($size == 'url') $img = ['url' => $img, 'alt' => $alt];
    else{
        $s = []; $s[$size] = $img;
        $img = ['alt'=>$alt, 'sizes'=>$s];

    }
    return getACFImgTag($img,$lazy,$class,$size,$atts);
}
function getACFImgTag($img, $lazy = true, $class = '', $size = 'url', $atts = ''){

    if(is_a($size,'ResponsiveSizeSetting')){
        ob_start();
        ?><img class="<?= $class ?> <?= $lazy ? 'lazy' : '';  ?>"
        <?= $size->getSrces($img, $lazy ? 'data-srcset' : 'srcset', $lazy ? 'data-src' : 'src' ); ?>
        <?= $size->getSizesSet($lazy ? 'data-sizes' : 'sizes' ); ?>
               alt="<?= $img['alt'];  ?>" <?= $atts; ?>><?php
        return ob_get_clean();
    }else{
        $src = $size == 'url' ? $img['url'] : $img['sizes'][$size];
        ob_start();
        ?><img class="<?= $class ?> <?= $lazy ? 'lazy' : '';  ?>" <?= $lazy ? 'data-' : '';  ?>src="<?= $src; ?>" alt="<?= $img['alt'];  ?>" <?= $atts; ?>><?php
        return ob_get_clean();
    }

}
/** Same as getACFImgTag but will echo the image instead of returning it.*/
function echoACFImgTag($img, $lazy = true, $class = '', $size = 'url', $atts = '', $wrapLinkURL='',$wrapLinkTarget='_self', $wrapClass=''){
    if(!empty($wrapLinkURL)){
        echo "<a href='{$wrapLinkURL}' target='{$wrapLinkTarget}' class='${wrapClass}'>";
    }
    echo getACFImgTag($img, $lazy, $class, $size, $atts);
    if(!empty($wrapLinkURL))
        echo '</a>';

}



/**
 * Retrieves an image by given name from the assets folder and returns the html img tag.
 * @param $imgName The filename of the image, supposed to be in themes assets/images folder
 * @param string $class Optional additional classes to add to the img.
 * @param string $alt An alt tag optionally
 * @param string $atts An optional string that will be added into the tag like 'data-toggle="pageBody"' for example.
 * @return string
 */
function getAssetsImgTag($imgName, $lazy= true, $class = '', $alt = '', $atts = ''){
    ob_start();
    ?><img class="<?= $class ?> <?= $lazy ? 'lazy' : '';  ?>" <?= $lazy ? 'data-' : '';  ?>src="<?= get_bloginfo('template_url').'/assets/images/'.$imgName; ?>" alt="<?= $alt;  ?>" <?= $atts;  ?>><?php
    return ob_get_clean();
}
/** Same as getAssetsImgTag but will echo the image instead of returning it.*/
function echoAssetsImgTag($imgName, $lazy= true, $class = '', $alt = '',$atts=''){ echo getAssetsImgTag($imgName,$lazy,$class,$alt, $atts);}

/**Returns an the url from an image in the assets/images folder*/
function getAssetImgURL($imgName){
    return get_bloginfo('template_url').'/assets/images/'.$imgName;
}

/**
 * Returns the additional style and data-src tags for an image to have inline background and lazy loading if desired
 * @param $imgUrl The url of the image to display.
 * @param bool $lazy if true data-src is added. The image also needs a "lazy" class to work properly.
 * @param string $bgSize like 'cover' or 'contain'
 * @param string $bgPos like 'center'
 * @param string $bgRepeat like 'no-repeat'
 * @param string $addData additional style attributes to add
 * @return string a string contianing style and data-src attributes, to echo inside the attributes of the html tag.
 */
function getImgStyle($imgUrl, $lazy=true, $bgSize = 'cover', $bgPos = 'center' , $bgRepeat="no-repeat", $addData = ''){
    if($lazy){
        return 'data-src="'.$imgUrl.'" style="background-repeat:'.$bgRepeat.'; background-position:'.$bgPos.'; background-size: '.$bgSize.'; '.$addData.'"';
    }else{
        return 'style="background:url('.$imgUrl.') '.$bgPos.' '.$bgRepeat.'; background-size: '.$bgSize.'; '.$addData.'"';
    }
}
function getACFImgStyle($img, $lazy= true, $imgSize='url', $bgSize = 'cover', $bgPos = 'center' , $bgRepeat='no-repeat', $addData = ''){
    $src = $imgSize == 'url' ? $img['url'] : $img['sizes'][$imgSize];
    return getImgStyle($src,$lazy, $bgSize, $bgPos, $bgRepeat, $addData);
}


//***************************************************************/
//* OTHER */
//***************************************************************/




/**Generates links for sharing on Twitter, Facebook or G+*/
function getShareLinks($url) {
	$url = str_replace('/','%2F',$url);
	$url = str_replace(':','%3A',$url);
	$link = [
		'fb' => 'https://www.facebook.com/sharer/sharer.php?u='.$url.'&amp;src=sdkpreparse',
		'gp' => 'https://plus.google.com/share?url='.$url,
		'tw' => 'https://twitter.com/home?status='.$url.'&amp;src=sdkpreparse'
	];
	return $link;
}
/**
 * Given a slug of a page or post in any language will give the translated WP_Post object
 * in the language currently active in sitepress
 * @param $slug The slug of a page e.g. "suchen"
 * @param $lang The language code to return 'de' or 'en'. If NULL will use the current language set by WPML.
 * @return array|null|WP_Post If slug not found will give null, if translation not found willgive the post in the language of the slug.
 */
function getPageByPathInCurLanguage($slug, $lang = null){
	$k = get_page_by_path($slug);
	if(!$k) return null;

	if($lang === null) $lang = ICL_LANGUAGE_CODE;

	global $sitepress;
	$translations = $sitepress->get_element_translations($sitepress->get_element_trid($k->ID));

	if(!$translations[$lang]) return $k; //there is no translation, return original post
	if($k->ID == $translations[$lang]->element_id) return $k; //post is same as desired language 

	return get_post($translations[$lang]->element_id); //return translation
}

/**
 * Retrieves the URL for a post thumbnail of the current or a specific post.
 * @param $size Wordpress image size like "medium"
 * @param null $forPost If provided will retrieve thumbnail url for a specific post
 * @return array|false null if no thumbnail found r the URL.
 */
function getThumbnailInSize($size, $forPost = null){
	$pid = get_post_thumbnail_id($forPost);
	if(!$pid) return null;
	return wp_get_attachment_image_src($pid,$size)[0];
}


function isDev(){
    return (strpos(get_bloginfo('url'),'pol.dv') !== FALSE);
}

function isFirstLoad(){

    $showPreloader = apply_filters('pol_add_preload_overlay',true);

    if($showPreloader){
        if(isset($_GET['pl'])||!isset($_SESSION['shown_preloader'])){
            $showPreloader = true;
        }else{
            $showPreloader = false;
        }
    }

    $_SESSION['shown_preloader'] = "true";

    return $showPreloader;
}

function getEventDate($eid){
    $s = get_field('start_date', $eid,false);
    $e = get_field('end_date', $eid,false);
    if(empty($s)) return 'Startdatum fehlt!';
    else if(empty($e)) return 'Enddatum fehlt!';
    else{
        $r = date('d.m.Y - G:i', $s);
        if(date('d', $s)==date('d',$e)){ //event on single day
            $r .= ' bis ' . date('G:i',$e);
        }else{
            $r .= ' ' . __('(mehrtägig)','pol');
        }
        return $r;
    }
}