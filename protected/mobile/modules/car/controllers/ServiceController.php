<?php

class ServiceController extends PublicController {

    public $layout = '//layouts/car_service';

    public function actionServiceone() {
        $this->render('service_one');
    }

    public function actionServicetwo() {
        $this->render('service_two');
    }

    public function actionServicethree() {
        $this->render('service_three');
    }

    public function actionWarrantyone() {
        $this->render('warranty_one');
    }

    public function actionWarrantytwo() {
        $this->render('warranty_two');
    }

    public function actionWarrantythree() {
        $this->render('warranty_three');
    }

    /**
     * Phụ kiện chính hãng
     */
    public function actionAccessoriesGenuine() {
        $this->render('accessories_genuine');
    }

    /**
     * Đặt lịch hẹn sửa chữa
     */
    public function actionScheduleRepair() {
        $model = new CarForm();
        if (isset($_POST['CarForm'])) {
            $model->attributes = $_POST['CarForm'];
            
            if ($model->time && $model->time != '' && (int) strtotime($model->time)) {
                $model->time = (int) strtotime($model->time);
            } else {
                $model->time = time();
            }
            
            $model->type = CarForm::SCHEDULE_REPAIR;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('car', 'schedule_repair_success'));
                $this->redirect(array('scheduleRepair'));
            }
        }
        $this->render('schedule_repair', array(
            'model' => $model
        ));
    }

    /**
     * Đăng ký lái thử xe
     */
    public function actionRegisterTryDrive() {
        
        $this->layoutForAction = '//layouts/car_customer_care';
        
        $model = new CarForm();

        if (isset($_POST['CarForm'])) {
            $model->attributes = $_POST['CarForm'];
            
            if ($model->time && $model->time != '' && (int) strtotime($model->time)) {
                $model->time = (int) strtotime($model->time);
            } else {
                $model->time = time();
            }
            
            $model->type = CarForm::TRY_DRIVE_CAR;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('car', 'register_trydrive_success'));
                $this->redirect(array('resgisterTryDrive'));
            }
        }

        $cars = Car::getAllCar('id, name', array('allow_try_drive' => ActiveRecord::STATUS_ACTIVED));
        $this->render('try_drive', array(
            'model' => $model,
            'cars' => $cars,
        ));
    }

    public function actionGetImageCar() {
        $car_id = Yii::app()->request->getParam('car_id', 0);
        if ($car_id) {
            $car = Car::model()->findByPk($car_id);
            if (!$car) {
                $this->jsonResponse(404);
            }
            $src = ClaHost::getImageHost() . $car['avatar_path'] . $car['avatar_name'];
            $this->jsonResponse(200, array(
                'src' => $src
            ));
        } else {
            $this->sendResponse(404);
        }
    }
    
    public function actionRegisterReceiveNews() {
        $this->layoutForAction = '//layouts/car_customer_care';
        
        $model = new CarForm();
        
        if (isset($_POST['CarForm'])) {
            $model->attributes = $_POST['CarForm'];
            
            if ($model->time && $model->time != '' && (int) strtotime($model->time)) {
                $model->time = (int) strtotime($model->time);
            } else {
                $model->time = time();
            }
            
            $model->type = CarForm::REGISTER_RECEIVE_NEWS;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('car', 'register_receive_news_success'));
                $this->redirect(array('registerReceiveNews'));
            }
        }
        
        $this->render('register_receive_news', array(
            'model' => $model,
        ));
    }
    
    public function actionCustomerIdea() {
        $this->layoutForAction = '//layouts/car_customer_care';
        
        $model = new CarForm();
        
        if (isset($_POST['CarForm'])) {
            $model->attributes = $_POST['CarForm'];
            $model->type = CarForm::CUSTOMER_IDEA;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('car', 'customer_idea_success'));
                $this->redirect(array('customerIdea'));
            }
        }
        
        $this->render('customer_idea', array(
            'model' => $model,
        ));
    }

}
