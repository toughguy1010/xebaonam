<?php

/**
 * Login Module
 *
 * @author minhbachngoc
 * @since 10/21/2013 16:10
 */
class LoginModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'login.models.*',
            'login.components.*',
            'login.commons.*',
            'login.widgets.*',
        ));
        if (ClaSite::isMobile()) {
            //
            $this->setImport(array('application.mobile.modules.login.controllers.*'));
            $this->controllerMap = array(
                'login' => array('class' => 'LoginController',),
            );
            $this->setViewPath(YiiBase::getPathOfAlias('application.mobile.modules.login.views'));
        }
    }

    /**
     * @return bool to allow go to action in that controller again?
     */
    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
