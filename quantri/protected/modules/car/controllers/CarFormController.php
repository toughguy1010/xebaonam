<?php

class CarFormController extends BackController {

    public function actionScheduleRepair() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('car', 'manager_schedule_repair') => Yii::app()->createUrl('/car/carForm/scheduleRepair'),
        );

        $model = new CarForm();
        $model->type = CarForm::SCHEDULE_REPAIR;
        $model->site_id = $this->site_id;
        $this->render('list_schedule_repair', array(
            'model' => $model,
        ));
    }
    
    public function actionRegisterReveiceNews() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('car', 'manager_register_receive_news') => Yii::app()->createUrl('/car/carForm/registerReveiceNews'),
        );

        $model = new CarForm();
        $model->type = CarForm::REGISTER_RECEIVE_NEWS;
        $model->site_id = $this->site_id;
        $this->render('list_register_receive_news', array(
            'model' => $model,
        ));
    }
    
    public function actionCustomerIdea() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('car', 'manager_customer_idea') => Yii::app()->createUrl('/car/carForm/customerIdea'),
        );

        $model = new CarForm();
        $model->type = CarForm::CUSTOMER_IDEA;
        $model->site_id = $this->site_id;
        $this->render('list_customer_idea', array(
            'model' => $model,
        ));
    }
    
    public function actionTryDriveCar() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('car', 'manager_try_drive_car') => Yii::app()->createUrl('/car/carForm/tryDriveCar'),
        );

        $model = new CarForm();
        $model->type = CarForm::TRY_DRIVE_CAR;
        $model->site_id = $this->site_id;
        $this->render('list_try_drive_car', array(
            'model' => $model,
        ));
    }
    
    public function actionDelete($id) {
        $car_form = CarForm::model()->findByPk($id);
        if ($car_form->site_id != $this->site_id) {
            $this->jsonResponse(400);
        }
        $car_form->delete();
    }

}
