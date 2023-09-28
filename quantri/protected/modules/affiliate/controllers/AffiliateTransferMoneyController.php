<?php

class AffiliateTransferMoneyController extends BackController {

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'affiliate_transfer_money') => Yii::app()->createUrl('affiliate/affiliateTransferMoney/'),
            Yii::t('affiliate', 'update_transfer_money') => Yii::app()->createUrl('affiliate/affiliateTransferMoney/update', array('id' => $id)),
        );
        $model = $this->loadModel($id);
        //
        if (isset($_POST['AffiliateTransferMoney'])) {
            $model->attributes = $_POST['AffiliateTransferMoney'];
            if ($model->image) {
                $avatar = Yii::app()->session[$model->image];
                if ($avatar) {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'affiliate_transfer_money') => Yii::app()->createUrl('affiliate/affiliateTransferMoney/'),
        );
        //
        $model = new AffiliateTransferMoney('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['AffiliateTransferMoney'])) {
            $model->attributes = $_GET['AffiliateTransferMoney'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AffiliateTransferMoney the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = AffiliateTransferMoney::model()->findByPk($id);
        //
        if ($model->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        return $model;
    }

    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 5) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '5Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'transfer', 'image'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

}
