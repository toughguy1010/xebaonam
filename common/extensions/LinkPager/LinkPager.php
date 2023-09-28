<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LinkPager
 *
 * @author minhbn
 * @editor : Hatv
 * - Update addZero
 * - Update head link rel
 */
class LinkPager extends CLinkPager {

    public $addZero = false;
    public $shownextPage = true;
    public $showprevPage = true;
    public $showlastPage = true;
    public $showfirstPage = true;
    public $cssFile = false;

    /**
     * Initializes the pager by setting some default property values.
     */
    public function init() {
        if ($this->nextPageLabel === null)
            $this->nextPageLabel = '&raquo;';
        if ($this->prevPageLabel === null)
            $this->prevPageLabel = '&laquo;';
        if ($this->firstPageLabel === null)
            $this->firstPageLabel = Yii::t('common', 'first_page');
        if ($this->lastPageLabel === null)
            $this->lastPageLabel = Yii::t('common', 'last_page');
        if ($this->header === null)
            $this->header = Yii::t('yii', 'Go to page: ');

        if (!isset($this->htmlOptions['id']))
            $this->htmlOptions['id'] = $this->getId();
        if (!isset($this->htmlOptions['class']))
            $this->htmlOptions['class'] = 'W3NPager';
    }

    /**
     * Creates the page buttons.
     * @return array a list of page buttons (in HTML code).
     */
    protected function createPageButtons() {
        if (($pageCount = $this->getPageCount()) <= 1)
            return array();

        list($beginPage, $endPage) = $this->getPageRange();
        $linkNextAndPrev = '';

        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $buttons = array();

        // first page
        if ($this->showfirstPage)
            $buttons[] = $this->createPageButton($this->firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);

        // prev page
        if (($page = $currentPage - 1) < 0)
            $page = 0;
        if ($this->showprevPage){
            $buttons[] = $this->createPageButton($this->prevPageLabel, $page, $this->previousPageCssClass, $currentPage <= 0, false);
            // Add head rel - Google ping
            if($currentPage > 0){
                $linkNextAndPrev .= '<link rel="prev" href="'.$this->createPageUrl($page).'">' . "\n";
            }
        }

        // internal pages
        if($this->addZero){
            for ($i = $beginPage; $i <= $endPage; ++$i){
                $prefix = ($i < 9) ? '0':'';
                $buttons[] = $this->createPageButton($prefix.($i + 1), $i, $this->internalPageCssClass, false, $i == $currentPage);
            }
        }else{
            for ($i = $beginPage; $i <= $endPage; ++$i)
                $buttons[] = $this->createPageButton($i + 1, $i, $this->internalPageCssClass, false, $i == $currentPage);
        }

        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1)
            $page = $pageCount - 1;
        if ($this->shownextPage){
            $buttons[] = $this->createPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
            // Add head rel
            if($currentPage < $pageCount - 1){
                $linkNextAndPrev .= '<link rel="next" href="'.$this->createPageUrl($page).'">' . "\n";
            }
        }
        // last page
        if ($this->showlastPage)
            $buttons[] = $this->createPageButton($this->lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);

        //
        Yii::app()->clientScript->setHeadString($linkNextAndPrev);
        return $buttons;
    }

    protected function createPages() {
        $pagination = new CPagination;
        $pagination->pageVar = ClaSite::PAGE_VAR;
        return $pagination;
    }

}
