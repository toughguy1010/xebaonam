<?php

/*
 * Translate 
 */

class translate extends CWidget {

    public $baseUrl = '';
    public $params = array();
    public $iconClass = '';
    public $translatedClass = 'translated';
    public $model = false; // Check model(ActiveRecord) is translate or not
    protected $view = 'view';
    protected $languages = array();

    public function init() {
        parent::init();
        $this->languages = ClaSite::getLanguagesForSite();
        unset($this->languages[ClaSite::getDefaultLanguage()]);
    }

    public function run() {
        $this->render($this->view, array(
            'baseUrl' => $this->baseUrl,
            'params' => $this->params,
            'iconClass' => $this->iconClass,
            'languages' => $this->languages,
            'model' => $this->model,
            'translatedClass' => $this->translatedClass,
        ));
    }

}
