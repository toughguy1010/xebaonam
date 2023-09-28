<?php

class CarTryDriverController extends BackController
{

    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('car', 'manager_try_drive_car') => Yii::app()->createUrl('/car/carTryDriver'),
        );

        $model = new CarTryDriver('search');
        if (isset($_GET['CarTryDriver']))
            $model->attributes = $_GET['CarTryDriver'];
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
    {
        $model = CarRegisterService::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        if ($model->delete()) {
            $this->jsonResponse(200);
            return;
        }
        $this->jsonResponse(400);
    }

}
