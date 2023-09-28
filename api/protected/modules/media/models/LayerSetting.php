<?php

/*
 * Các cấu hình cho slider;
 */

/**
 * Description of SliderSetting
 *
 * @author minhbn
 */
class SliderSetting extends FormModel {

    //
    public $post_orderby = 'date';
    public $post_order = 'DESC';
    public $post_offset = -1;
    public $title = '';
    public $slug = '';
    public $width = 800;
    public $height = 600;
    public $fullwith = 0;
    public $responsive = 1; // 1 on, 0: off
    public $maxwidth = '';
    public $responsiveunder = 0;
    public $sublayercontainer = 0;
    public $hideonmobile = 0;
    public $hideunder = 0;
    public $hideover = 100000;
    public $autostart = 1; // 1 on, 0: off
    public $startinviewport = 1; // 1 on, 0: off
    public $pauseonhover = 1; // 1 on, 0: off
    public $firstlayer = 1;
    public $animatefirstlayer = 1; // 1 on, 0: off
    public $keybnav = 1; // 1 on, 0: off
    public $touchnav = 1; // 1 on, 0: off
    public $loops = 0;
    public $forceloopnum = 1; // 1 on, 0: off
    public $twowayslideshow = 0; //1 on, 0: off
    public $randomslideshow = 0; //1 on, 0: off
    public $skin = 'v5';
    public $backgroundcolor = 'rgba(0,0,0, 0)';
    public $backgroundimageId = 0;
    public $backgroundimage = '';
    public $sliderfadeinduration = 350;
    public $sliderstyle = '';
    public $ls_data = array();
    public $navprevnext = 1; // 1 on, 0: off
    public $navstartstop = 1; // 1 on, 0: off
    public $navbuttons = 1; // 1 on, 0: off
    public $hoverprevnext = 1; // 1 on, 0: off
    public $hoverbottomnav = 1; // 1 on, 0: off
    public $circletimer = 1; // 1 on, 0: off
    public $thumb_nav = 'hover';
    public $thumb_container_width = '60%';
    public $thumb_width = 100;
    public $thumb_height = 60;
    public $thumb_active_opacity = 40;
    public $thumb_inactive_opacity = 100;
    public $autoplayvideos = 1; // 1 on, 0: off
    public $autopauseslideshow = 'auto';
    public $youtubepreview = '';
    public $imgpreload = 1; // 1: on, 0: off
    public $lazyload = 1; // 1: on, 0: off
    public $yourlogoId = 0;
    public $yourlogo = '';
    public $yourlogostyle = '';
    public $yourlogolink = '';
    public $yourlogotarget = '';
    public $showbartimer = 0;
    public $showcircletimer = 1;
    public $relativeurls = 0; //

    /**
     * get all skin for slider
     * @return type
     */

    function getSkinArr() {
        return array(
            'borderlessdark' => 'Borderless Dark',
            'borderlessdark3d' => 'Borderless Dark for 3D sliders',
            'borderlesslight' => 'Borderless Light',
            'borderlesslight3d' => 'Borderless Light for 3D sliders',
            'carousel' => 'Carousel',
            'darkskin' => 'Dark',
            'defaultskin' => 'Default',
            'fullwidth' => 'Full-width',
            'fullwidthdark' => 'Full-width Dark',
            'glass' => 'Glass',
            'lightskin' => 'Light',
            'minimal' => 'Minimal',
            'noskin' => 'No skin - Hides everything, including buttons',
            'v5' => 'v5',
        );
    }

    /**
     * get Thumbnail navigation
     */
    function getThumbnailNavigationArr() {
        return array(
            'disabled' => Disabled,
            'hover' => 'Hover',
            'always' => 'Always',
        );
    }

    //
    /*
     * get Pause slideshow
     */
    function getPauseSlideshowArr() {
        return array(
            "auto" => 'While playing',
            "enabled=" => 'Permanently',
            "disabled" => 'No action',
        );
    }

    //
    function getYoutubePreviewArr() {
        return array(
            "maxresdefault.jpg" => 'Maximum quality',
            "hqdefault.jpg" => 'High quality',
            "mqdefault.jpg" => 'Medium quality',
            "default.jpg" => 'Default quality',
        );
    }

    //
    /*
     * Get link target
     */
    function getLinkTargetArr() {
        return array(
            "_self" => 'Open on the same page',
            "_blank" => 'Open on new page',
            "_parent" => 'Open in parent frame',
            "_top" => 'Open in main frame',
        );
    }

    //
}
