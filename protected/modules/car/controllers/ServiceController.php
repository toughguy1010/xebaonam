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
                $url = Yii::app()->createUrl('car/service/registerTryDrive');
                $this->redirect($url);
            }
        }

        $cars = Car::getAllCar('id, name', array('allow_try_drive' => ActiveRecord::STATUS_ACTIVED));
        $this->render('try_drive', array(
            'model' => $model,
            'cars' => $cars,
        ));
    }

    /**
     * Đăng ký lái thử xe V2 - cong
     */
    public function actionRegisterTryDriveV2() {

        $this->layoutForAction = '//layouts/car_customer_care';

        $model = new CarTryDriver();

        if (isset($_POST['CarTryDriver'])) {
            $model->site_id = $this->site_id;
            $model->attributes = $_POST['CarTryDriver'];

            if ($model->date_coming && $model->date_coming != '' && (int) strtotime($model->date_coming)) {
                $model->date_coming = (int) strtotime($model->date_coming);
            }
            $model->created_time = $model->modified_time = time();
            if ($model->save()) {
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'register_try_drive_v2',
                ));
                if ($mailSetting) {
                    $cars = Car::getCarsByIds(explode(',', $model->car_id));
                    $car_name = '';
                    if($cars) {
                        $cars = array_column($cars, 'name');
                        $car_name = implode(', ', $cars);
                    }
                    $data = [
                        'user_name' =>  $model['user_name'],
                        'phone' => $model['phone'],
                        'email' => $model['email'],
                        'car_name' => $car_name,
                        'date_coming' => date('d-m-Y', $model['date_coming']),
                        'time_coming' => $model['time_coming'],
                    ];
                    $content = $mailSetting->getMailContent($data);
                    $subject = $mailSetting->getMailSubject($data);
                    $mail_admin = Yii::app()->siteinfo["admin_email"];
                    if ($content && $subject && $mail_admin) {
                        Yii::app()->mailer->send('', $mail_admin, $subject, $content);
                    }
                }
                $car_selected = Car::getByIdStrings($model->car_id);
                $this->renderPartial('try_drive_success_v2', array(
                    'model' => $model,
                    'data' => $car_selected,
                ));
                return true;
            }
            echo 'Lưu không thành công';
            if (isset($_GET['debug'])) {
                echo "<pre>";
                print_r($_POST['CarTryDriver']);
                print_r($model->errors);
                echo "</pre>";
            }
            return false;
        }

        $data = Car::getData(array('allow_try_drive' => ActiveRecord::STATUS_ACTIVED, 'limit' => 100));
        $components['time_coming'] = CarTryDriver::arrTimeComing();
        $this->render('try_drive_v2', array(
            'model' => $model,
            'data' => $data,
            'components' => $components
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

    /**
     * Đăng ký dịch vụ Toyota
     */
    public function actionRegisterService() {
        $this->layoutForAction = '//layouts/car_register_service';
        $services = CarService::getAllService();
        // $labels = CarRegisterService::optionsLabel();
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_CAR;
        $category->generateCategory();
        $options = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $array);
        //
        $times = CarRegisterService::optionsTime();
        //
        $model = new CarRegisterService();
        if (isset($_POST['CarRegisterService'])) {
            $model->attributes = $_POST['CarRegisterService'];
            if ($model->date_coming && $model->date_coming != '' && (int) strtotime($model->date_coming)) {
                $model->date_coming = (int) strtotime($model->date_coming);
            }
            $model->key = ClaGenerate::getUniqueCode(array('prefix' => 'c'));
            if(isset($model->services) && $model->services) {
                $model->services = implode(', ', $model->services);
            }
            if ($model->save()) {
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'car_register_service',
                ));
                if ($mailSetting) {
                    $cat = CarCategories::model()->findByPk($model['car_category_id']);
                    $car = Car::model()->findByPk($model['car_id']);
                    $data = [
                        // 'dir' => CarRegisterService::getNameLabel($model['customer_label']),
                        'user_name' =>  $model['customer_name'],
                        'phone' => $model['customer_phone'],
                        'email' => $model['customer_email'],
                        'service' => $model['services'],
                        'car_type' => isset($cat['cat_name']) ? $cat['cat_name'] : '',
                        'car_version' => isset($car['name']) ? $car['name'] : '',
                        'license_plate' => $model['license_plate'],
                        'year_produce' => $model['year_produce'],
                        'date_coming' => date('d.m.Y', $model['date_coming']),
                        'time_coming' => CarRegisterService::getNameTime($model['time_coming']),
                        // 'place' => $model['place'],
                        // 'employee' => $model['employee'],
                        'note' => $model['customer_note'],
                    ];
                    $content = $mailSetting->getMailContent($data);
                    $subject = $mailSetting->getMailSubject($data);
                    $mail_admin = Yii::app()->siteinfo["admin_email"];
                    if ($content && $subject && $mail_admin) {
                        Yii::app()->mailer->send('', $mail_admin, $subject, $content);
                    }
                }
                $this->redirect(Yii::app()->createUrl('/car/service/registerServiceSuccess', array(
                            'id' => $model->id,
                            'key' => $model->key,
                )));
            } else {
                echo '<pre>';
                print_r($model->getErrors());
                echo '</pre>';
                die();
            }
        }
        //
        $this->render('register_service', [
            'services' => $services,
            'times' => $times,
            // 'labels' => $labels,
            'options' => $options
        ]);
    }

    public function actionRegisterServiceSuccess() {
        $this->layoutForAction = '//layouts/car_register_service';
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        if ($id && $key) {
            $model = CarRegisterService::model()->findByPk($id);
            if (!$model) {
                $this->sendResponse(404);
            }
            if ($model->key != $key) {
                $this->sendResponse(404);
            }
            $this->render('register_service_success', [
                'model' => $model
            ]);
        }
    }

}
