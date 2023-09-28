<?php

/**
 * Created by minhbn
 * Date: 08/20/2013
 * Category: 
 */
class CrawlerLinkHelper extends BaseHelper {

    protected $rootLink = ''; // root link
    protected $fromPage = 1;
    protected $toPage = 1;
    protected $pageKey = 'page';
    protected $format = '';
    protected $increment = true;

    //
    function getLinks() {
        $fromPage = (int) $this->getFromPage();
        $toPage = (int) $this->getToPage();
        $pageKey = $this->getPageKey();
        $format = $this->getFormat();
        $rootLink = $this->getRootLink();
        $links = array();
        //
        if ($rootLink) {
            if ($this->getIncrement()) {
                for ($i = $fromPage; $i <= $toPage; $i++) {
                    $data = array(
                        'pageKey' => $pageKey,
                        'page' => $i,
                    );
                    $fstring = $this->parseFormat($data);
                    $link = $rootLink . $fstring;
                    $links[] = $link;
                }
            } else {
                for ($i = $toPage; $i >= $fromPage; $i--) {
                    $data = array(
                        'pageKey' => $pageKey,
                        'page' => $i,
                    );
                    $fstring = $this->parseFormat($data);
                    $link = $rootLink . $fstring;
                    $links[] = $link;
                }
            }
        }
        return $links;
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    function parseFormat($data = array()) {
        $string = $this->getFormat();
        if (!$data) {
            return $string;
        }
        $search = array();
        $replace = array();
        foreach ($data as $key => $val) {
            $search[] = '[' . $key . ']';
            $replace[] = $val;
        }
        $string = str_replace($search, $replace, $string);
        return $string;
    }

    //
    function getRootLink() {
        return $this->rootLink;
    }

    function getFromPage() {
        return $this->fromPage;
    }

    function getToPage() {
        return $this->toPage;
    }

    function getPageKey() {
        return $this->pageKey;
    }

    function getFormat() {
        return $this->format;
    }

    function setRootLink($rootLink) {
        $this->rootLink = $rootLink;
    }

    function setFromPage($fromPage) {
        $this->fromPage = $fromPage;
    }

    function setToPage($toPage) {
        $this->toPage = $toPage;
    }

    function setPageKey($pageKey) {
        $this->pageKey = $pageKey;
    }

    function setFormat($format) {
        $this->format = $format;
    }

    function getIncrement() {
        return $this->increment;
    }

    function setIncrement($increment) {
        $this->increment = $increment;
    }

}
