<?php

/**
 * app Module
 *
 * @author QuangTS
 * @since 11/01/2022 16:10
 */
class AppModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'app.models.*',
            'app.components.*',
            'app.classs.*',
            'app.widgets.*',
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
