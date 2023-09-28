<?php

class IntroduceController extends PublicController {

    public $layout = '//layouts/introduce';

    public function actionIndex() {
//        $this->pageTitle = Yii::t('common', 'introduce');
        $this->pageTitle = Yii::app()->siteinfo['site_title'];
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_name = Yii::app()->request->getParam('store');
            if ($store_name != '') {
                $store = ShopStore::model()->findByAttributes(array(
                    'alias' => $store_name,
                    'site_id' => Yii::app()->controller->site_id
                ));
                if (isset($store->id) && $store->id) {
                    $_SESSION['store'] = $store->id;
                }
            }
        }
        $fr = Yii::app()->request->getParam('fr', '');
        if (isset($fr) && $fr) {
            $_SESSION['fr'] = $fr;
        }
        $this->render('index');
    }

}
