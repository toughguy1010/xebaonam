<?php

class searchsuggest extends WWidget {

    protected $action;
    protected $placeHolder = '';
    protected $keyName = ClaSite::SEARCH_KEYWORD;
    protected $keyWord = '';
    protected $method = 'post';
    protected $limit = 10;
    protected $type;
    protected $view = 'view';
    protected $name = 'searchsuggest';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_searchsuggest = new config_searchsuggest('', array('page_widget_id' => $this->page_widget_id));
        if ($config_searchsuggest) {
            $this->widget_title = $config_searchsuggest->widget_title;
            $this->limit = $config_searchsuggest->limit;
            $this->placeHolder = $config_searchsuggest->placeHolder;
        }
        if (!$this->placeHolder) {
            $this->placeHolder = Yii::t('common', 'search_placeholder');
        }
        $this->keyWord = Yii::app()->request->getParam($this->keyName, '');
        if (!$this->keyWord) {
            $this->keyWord = '';
        }
        //
        $this->action = Yii::app()->createUrl('/search/search/suggest');
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
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
        ));
    }

}
