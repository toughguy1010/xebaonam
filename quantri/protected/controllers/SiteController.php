<?php

class SiteController extends BackController {

    /**
     * Declares class-based actions.
     */
    public function actioncreateadminmenudefualt() {
//        $site_id = Yii::app()->request->getParam('sid');
//        if (!$site_id)
//            die('site_id not null');
//        $dataPath = Yii::getPathOfAlias('common') . '/lib/menuadmin.sql';
//        echo $dataPath;
//        $sql = '';
//        if (file_exists($dataPath)) {
//            $sql = trim(file_get_contents($dataPath));
//        }
//        $sql = str_replace(array('[site_id]', '[user_id]', '[now]'), array($site_id, Yii::app()->user->id, time()), $sql);
//        if ($sql) {
//            $respond = Yii::app()->db->createCommand($sql)->execute();
//            if ($respond) {
//                //
//                die('ok');
//            }
//        }
    }

    /**
     * Clear cache
     */
    function actionClearcache() {
        if (ClaUser::isSupperAdmin() || Yii::app()->controller->admin->isRoot()) {
            Yii::app()->session->clear();
            Yii::app()->cache->flush();
            Yii::app()->clientScript->registerScript('notfound', 'setTimeout(function(){window.location.href="' . Yii::app()->homeUrl . '"},3000)');
            $this->render('clearcache');
            Yii::app()->end();
        }
    }

    /**
     * create site map
     * @return boolean
     */
    function actionCreatesitemap() {
        ClaSite::createSiteMapFromMenu();
        Yii::app()->user->setFlash('success', Yii::t('common', 'createsuccess'));
        $this->redirect(Yii::app()->homeUrl);
        Yii::app()->end();
    }

    /**
     * delete site
     */
    public function actionDeletesite() {
        if (!ClaUser::isSupperAdmin())
            return false;
        $site_id = Yii::app()->request->getParam('id');
        $domain = Yii::app()->request->getParam('domain');
        if (!$site_id && !$domain) {
            echo 'Invalid input';
            Yii::app()->end();
        }
        if (!$site_id)
            $site_id = ClaSite::getSiteIdFromDomain($domain);
        if (!$site_id || $site_id == 1)
            Yii::app()->end();
        //
        SiteSettings::deleteSite($site_id);
        //echo $sql;
        echo 'Delete site success';
        Yii::app()->end();
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * disable site
     */
    function actionDisable() {
        $this->layout = 'disable';
        $this->render('disable');
    }

}
