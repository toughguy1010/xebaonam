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
            'login.classs.*',
            'login.widgets.*',
        ));
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
