<?php

class SearchModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'search.models.*',
            'search.components.*',
            'search.libs.*',
        ));
        if (ClaSite::isMobile()) {
            //
            $this->setImport(array('application.mobile.modules.search.controllers.*'));
            $this->controllerMap = array(
                'search' => array('class' => 'SearchController',),
            );
            $this->setViewPath(YiiBase::getPathOfAlias('application.mobile.modules.search.views'));
        }
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
