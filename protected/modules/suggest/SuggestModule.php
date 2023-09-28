<?php

class SuggestModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'suggest.models.*',
            'suggest.components.*',
        ));
        if (ClaSite::isMobile()) {
            //
            $this->setImport(array('application.mobile.modules.suggest.controllers.*'));
            $this->controllerMap = array(
                'api' => array('class' => 'ApiController',),
                'suggest' => array('class' => 'SuggestController',),
            );
            $this->setViewPath(YiiBase::getPathOfAlias('application.mobile.modules.suggest.views'));
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
