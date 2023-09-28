<?php

/**
 * @author minhbn <minhcoltech@gmail.com>
 * get link host, host info
 */
class ClaHost {

    /**
     * Get host upload for images and files
     */
    static function getUploadHost() {
        $servername = ClaSite::getServerName();
        return ClaSite::getHttpMethod(true) . $servername . '/mediacenter';
    }
    /**
     * Get host server
     */
    static function getServerHost(){
        $servername = ClaSite::getServerName();
        return ClaSite::getHttpMethod(true) . $servername;
    }
    /**
     * get host view images
     */
    static function getImageHost() {
        $servername = ClaSite::getServerName();
        return ClaSite::getHttpMethod(true) . $servername . '/mediacenter';
    }

    static function getImageHostHttps() {
        $servername = ClaSite::getServerName();
        return ClaSite::getHttpMethod(true) . $servername . '/mediacenter';
    }

    /**
     * tr? v? du?ng d?n tuong d?i c?a media
     */
    static function getMediaBasePath() {
        return '/mediacenter';
    }

}
