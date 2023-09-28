<?php

class ProvinceController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'province_manager') => Yii::app()->createUrl('/tour/province'),
        );
        //
        $model = new LibProvinces('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['LibProvinces'])) {
            $model->attributes = $_GET['LibProvinces'];
        }
        
//        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'province_manager') => Yii::app()->createUrl('/tour/province'),
            Yii::t('tour', 'province_update') => Yii::app()->createUrl('/tour/province/update'),
        );
        $province = LibProvinces::model()->findByPk($id);

        $province_info = TourProvinceInfo::model()->findByAttributes(array(
            'province_id' => $province->province_id,
            'site_id' => Yii::app()->controller->site_id
        ));
        if (isset($_POST['TourProvinceInfo']) && $_POST['TourProvinceInfo']) {
            $province_info->attributes = $_POST['TourProvinceInfo'];
            if ($province_info->avatar) {
                $avatar = Yii::app()->session[$province_info->avatar];
                if ($avatar) {
                    $province_info->image_path = $avatar['baseUrl'];
                    $province_info->image_name = $avatar['name'];
                }
            }
            if ($province_info->save()) {
                if ($model->avatar) {
                    unset(Yii::app()->session[$model->avatar]);
                }
                $this->redirect(Yii::app()->createUrl("tour/province"));
            }
        }
        $this->render('update', array(
            'province' => $province,
            'province_info' => $province_info,
        ));
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'tour_province', 'ava'));
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

    public function actionImportInfo() {
        $data = Yii::app()->db->createCommand()->select()
                ->from('province')
                ->queryAll();
        $value = '';
        $site_id = Yii::app()->controller->site_id;
        foreach ($data as $item) {
            if ($value) {
                $value .= ',';
            }
            $value .= "('" . $item['province_id'] . "', '" . 1 . "', '" . 0 . "', '" . 1000 . "', '" . $site_id . "')";
        }

        $sql = 'INSERT INTO tour_province_info(province_id, status, showinhome, position, site_id) VALUES' . $value;
        Yii::app()->db->createCommand($sql)->execute();
        $this->redirect(Yii::app()->createUrl('/tour/province'));
    }

}
