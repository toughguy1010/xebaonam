<?php

/**
 * @author hungtm <hungtm.0712@gmail.com>
 */
class AffiliateConfigController extends BackController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'setting_affiliate') => Yii::app()->createUrl('affiliate/affiliateConfig'),
        );
        //
        $site_id = Yii::app()->controller->site_id;
        $model = $this->loadModel($site_id);
        if (!$model) {
            $this->sendResponse(404);
        }
        if (isset($_POST['AffiliateConfig'])) {
            $post = $_POST['AffiliateConfig'];
            $model->attributes = $post;
            //
            if ($model->save()) {
                //
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
            } else {
                echo "<pre>";
                print_r($model->getErrors());
                echo "</pre>";
                die();
            }
        }
        //
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SiteSettings the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $model = AffiliateConfig::model()->findByPk($id);
        //
        if ($model === NULL) {
            $model = new AffiliateConfig();
            $model->site_id = $id;
        }
        return $model;
    }

}
