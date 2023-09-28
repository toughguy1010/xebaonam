<?php

class CarRegisterServiceController extends BackController
{

    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('car', 'Quản lý đặt lịch hẹn sửa chữa') => Yii::app()->createUrl('/car/CarRegisterService'),
        );

        $model = new CarRegisterService('search');
        if (isset($_GET['CarRegisterService']))
            $model->attributes = $_GET['CarRegisterService'];
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
