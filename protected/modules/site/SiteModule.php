<?php

class SiteModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'site.models.*',
            'site.components.*',
            'site.helper.*',
        ));
        if (ClaSite::isMobile()) {
            //
            $this->setImport(array('application.mobile.modules.site.controllers.*'));
            $this->controllerMap = array(
                'site' => array('class' => 'SiteController',),
                'form' => array('class' => 'FormController',),
                'build' => array('class' => 'BuildController',),
                'request' => array('class' => 'RequestController',),
            );
            $this->setViewPath(YiiBase::getPathOfAlias('application.mobile.modules.site.views'));
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
