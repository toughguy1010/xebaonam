<?php

/**
 * @author hungtm <hungtm.0712@gmail.com>
 * @date 08/03/2017
 */
class GiftCardConfigController extends BackController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    public function allowedActions() {
        return 'uploadfile';
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            'Gift Card Config' => Yii::app()->createUrl('banner/giftCardConfig'),
        );
        //
        $site_id = Yii::app()->controller->site_id;
        $model = $this->loadModel($site_id);
        if (isset($_POST['GiftCardConfig'])) {
            $post = $_POST['GiftCardConfig'];
            $model->attributes = $post;
            if (!$model->site_id) {
                $model->site_id = Yii::app()->controller->site_id;
            }
            //
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
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
        $model = GiftCardConfig::model()->findByPk($id);
        //
        if ($model === NULL) {
            $model = new GiftCardConfig();
        }
        return $model;
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            // Dung lượng nhỏ hơn 1Mb
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            //$up->uploadFile();
            $up->setPath(array($this->site_id, 'logo'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $return['data']['realurl'] = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

}
