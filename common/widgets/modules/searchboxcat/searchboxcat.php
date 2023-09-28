<?php

class searchboxcat extends WWidget {

    protected $action;
    protected $placeHolder = '';
    protected $keyName = ClaSite::SEARCH_KEYWORD;
    protected $keyWord = '';
    protected $method = 'get';
    protected $view = 'view';
    protected $name = 'searchboxcat';
    protected $type;
    protected $showcat = false;
    protected $catKey = ClaCategory::CATEGORY_KEY;
    protected $options;
    protected $optionDepth = 2;
    protected $catOptions = '';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $this->placeHolder = Yii::t('common', 'search_placeholder');
        // Load config
        $config_searchbox = new config_searchboxcat('', array('page_widget_id' => $this->page_widget_id));
        if ($config_searchbox) {
            $this->widget_title = $config_searchbox->widget_title;
            $this->showcat = $config_searchbox->showcat;
        }
        //
        $this->keyWord = Yii::app()->request->getParam($this->keyName);
        if (!$this->keyWord)
            $this->keyWord = '';
//        $parser = new CHtmlPurifier(); //create instance of CHtmlPurifier
//        $this->keyWord = $parser->purify($this->keyWord); //we purify the $user_input
        $this->keyWord = CHtml::encode($this->keyWord);
        //
        $this->type = Yii::app()->request->getParam(ClaSite::SEARCH_TYPE);
        if (!$this->type) {
            $link = Yii::app()->controller->module->id;
            switch ($link) {
                case 'news': $this->type = ClaSite::SITE_TYPE_NEWS;
                    break;
                case 'economy': $this->type = ClaSite::SITE_TYPE_ECONOMY;
                    break;
                default: {
                        $this->type = Yii::app()->siteinfo['site_type'];
                    }break;
            }
        }
        //
        switch ($this->type) {
            case ClaSite::SITE_TYPE_NEWS: {
                    $this->placeHolder = Yii::t('common', 'search_news');
                    //
                    if ($this->showcat) {
                        $category = new ClaCategory();
                        $category->type = ClaCategory::CATEGORY_NEWS;
                        $category->generateCategory();
                        $arr = array(0 => Yii::t('common', 'all'));
                        $this->options = $category->createOptionArrayWithDepth(ClaCategory::CATEGORY_ROOT, $this->optionDepth, array('jump' => 3), $arr);
                    }
                }
                break;
            case ClaSite::SITE_TYPE_ECONOMY: {
                    $this->placeHolder = Yii::t('common', 'search_product');
                    //
                    if ($this->showcat) {
                        $category = new ClaCategory();
                        $category->type = ClaCategory::CATEGORY_PRODUCT;
                        $category->generateCategory();
                        $arr = array(0 => Yii::t('common', 'all'));
                        $this->options = $category->createOptionArrayWithDepth(ClaCategory::CATEGORY_ROOT, $this->optionDepth, array('jump' => 3), $arr);
                    }
                }break;
        }
        //
        if ($this->showcat && $this->options) {
            $this->catOptions = CHtml::dropDownList($this->catKey, Yii::app()->request->getParam($this->catKey), $this->options, array('encode' => false, 'class' => 'searchSelect'));
        }
        //
        $this->action = Yii::app()->createUrl('/search/search/searchbyCat');
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.searchbox.' . $this->view;
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        //
        $this->registerScript();
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'method' => $this->method,
            'action' => $this->action,
            'type' => $this->type,
            'keyName' => $this->keyName,
            'keyWord' => $this->keyWord,
            'placeHolder' => $this->placeHolder,
            'catOptions' => $this->catOptions,
            'showcat' => $this->showcat,
        ));
    }

    /**
     * đăng ký script
     */
    function registerScript() {
        if (!defined('searchbox')) {
            define('searchbox', 'true');
            Yii::app()->clientScript->registerScript("searchbox", ""
                    . "jQuery(document).on('submit', '.searchform', function() {
                                        var sv = jQuery(this).find('.inputSearch').val();
                                        if (sv == '' || sv.length < 2) {
                                            alert('" . Yii::t('errors', 'keyword_invalid') . "');
                                            return false;
                                        }
                                    });
                                    if(jQuery('.searchbox .searchSelect option:selected').val()){
                                            var categorybox = jQuery('.searchbox .searchSelect').closest('.search-category-select');
                                            if(categorybox){
                                                categorybox.find('.search-category-text').text(categorybox.find('.searchSelect option:selected').text());
                                            }
                                            
                                        }
                                       
                                    jQuery('.searchbox .searchSelect').on('change', function() {
                                        jQuery(this).closest('.search-category-select').find('.search-category-text').text(jQuery(this).find('option:selected').text());
                                    });
                                    "
                    , CClientScript::POS_END);
        }
    }

}
