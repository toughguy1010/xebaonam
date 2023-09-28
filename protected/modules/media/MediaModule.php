<?php

class MediaModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'media.models.*',
            'media.components.*',
            'media.helper.*',
        ));
        if (ClaSite::isMobile()) {
            //
            $this->setImport(array('application.mobile.modules.media.controllers.*'));
            $this->controllerMap = array(
                'album' => array('class' => 'AlbumController',),
                'media' => array('class' => 'MediaController',),
                'video' => array('class' => 'VideoController',),
            );
            $this->setViewPath(YiiBase::getPathOfAlias('application.mobile.modules.media.views'));
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
