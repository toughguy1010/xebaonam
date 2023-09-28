<?php

class WeatherLocationController extends BackController
{

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('setting', 'weatherLocation_manager') => Yii::app()->createUrl('/setting/weatherLocation'),
        );
        //
        $model = new WeatherLocation('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['WeatherLocation'])) {
            $model->attributes = $_GET['WeatherLocation'];
        }

//        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('setting', 'weatherLocation_manager') => Yii::app()->createUrl('/setting/weatherLocation'),
            Yii::t('setting', 'weatherLocation_update') => Yii::app()->createUrl('/setting/weatherLocation/update'),
        );
        $weatherLocation = WeatherLocation::model()->findByPk($id);

        if (isset($_POST['WeatherLocation']) && $_POST['WeatherLocation']) {
            $weatherLocation->attributes = $_POST['WeatherLocation'];
            $weatherLocation->site_id = $this->site_id;

            if ($weatherLocation->save()) {
                $this->redirect(Yii::app()->createUrl("setting/weatherLocation"));
            }
        }
        $this->render('update', array(
            'weatherLocation' => $weatherLocation,
        ));
    }

    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('setting', 'weatherLocation_manager') => Yii::app()->createUrl('/setting/weatherLocation'),
            Yii::t('setting', 'weatherLocation_update') => Yii::app()->createUrl('/setting/weatherLocation/update'),
        );
        $weatherLocation = new WeatherLocation();
        if (isset($_POST['WeatherLocation']) && $_POST['WeatherLocation']) {
            $weatherLocation->attributes = $_POST['WeatherLocation'];
            $weatherLocation->site_id = $this->site_id;

            if ($weatherLocation->save()) {
                $this->redirect(Yii::app()->createUrl("setting/weatherLocation"));
            }
        }
        //
        $this->render('create', array(
            'weatherLocation' => $weatherLocation,
        ));
    }

    /**
     * upload file
     */
    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'setting_weatherLocation', 'ava'));
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
