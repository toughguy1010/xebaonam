<?php

class BuycarController extends PublicController {

    public $layout = '//layouts/buy_car';

    const KEY_CAR_REGION = 'car_region_';
    const KEY_CAR_COLOR = 'car_color_';
    const KEY_CAR_ID = 'car_id_';
    const KEY_CAR_ACCESSORY = 'car_accessory_';

    /**
     * Dự toán chi phí hyundai
     * @param type $id
     */
    public function actionCalculateCost() {

        $cid = Yii::app()->request->getParam('cid', 0);

        $versions = array();
        if ($cid) {
            $versions = CarVersions::getAllVersions($cid, 'id, name');
        }

        $cars = Car::getAllCar('id, name');

        $regionals = CarReceiptFee::getAllRegional('id, name');

        $this->render('calculate_cost', array(
            'cars' => $cars,
            'regionals' => $regionals,
            'cid' => $cid,
            'versions' => $versions
        ));
    }

    /**
     * Dự toán chi phí toyota
     */
    public function actionCalculateCostToyota() {
        $this->layoutForAction = '//layouts/car_calculate';
        $cars = Car::getAllCar('*');
        $this->render('calculate_cost_toyota', [
            'cars' => $cars
        ]);
    }

    public function actionCalculateCostToyotaStep2($id) {
        $this->layoutForAction = '//layouts/car_calculate';
        $car = Car::model()->findByPk($id);
        $regionals = CarReceiptFee::getAllRegional('id, name');
        $this->render('calculate_cost_toyota_step2', [
            'car' => $car,
            'regionals' => $regionals
        ]);
    }

    public function actionCalculateCostToyotaStep3() {
        $this->layoutForAction = '//layouts/car_calculate';
        $car_id = $_SESSION['car_id'];
        $keyRegion = self::KEY_CAR_REGION . $car_id;
        $region = $_SESSION[$keyRegion];
        //
        $car = Car::model()->findByPk($car_id);
        $regionModel = CarReceiptFee::model()->findByPk($region);
        $colors = CarColors::getAllColors($car_id);
        //
        $accessories = CarAccessories::getAllAccessories($car_id);
        //
        $keyAccessory = self::KEY_CAR_ACCESSORY . $car_id;
        $accessoriesIds = $_SESSION[$keyAccessory];
        //
        $keyColor = self::KEY_CAR_COLOR . $car_id;
        $colorSet = isset($_SESSION[$keyColor]) ? $_SESSION[$keyColor] : 0;
        //
        $this->render('calculate_cost_toyota_step3', [
            'car' => $car,
            'regionModel' => $regionModel,
            'colors' => $colors,
            'accessories' => $accessories,
            'accessoriesIds' => $accessoriesIds,
            'colorSet' => $colorSet
        ]);
    }

    public function actionCalculateCostToyotaStep4() {
        $this->layoutForAction = '//layouts/car_calculate';
        $car_id = $_SESSION['car_id'];
        $keyRegion = self::KEY_CAR_REGION . $car_id;
        $region = $_SESSION[$keyRegion];
        //
        $car = Car::model()->findByPk($car_id);
        $regionModel = CarReceiptFee::model()->findByPk($region);
        //
        $keyAccessory = self::KEY_CAR_ACCESSORY . $car_id;
        $accessoriesIds = $_SESSION[$keyAccessory];
        //
        $keyColor = self::KEY_CAR_COLOR . $car_id;
        $colorSet = isset($_SESSION[$keyColor]) ? $_SESSION[$keyColor] : 0;
        //
        $key_send_mail = $car_id.'_calculate';
        $_SESSION[$key_send_mail] = [
            'car' => $car,
            'regionModel' => $regionModel,
            'accessoriesIds' => $accessoriesIds,
            'colorSet' => $colorSet
        ];
        $this->render('calculate_cost_toyota_step4', [
            'car' => $car,
            'regionModel' => $regionModel,
            'accessoriesIds' => $accessoriesIds,
            'colorSet' => $colorSet,
            'key_send_mail' => $key_send_mail,
        ]);
    }

    //cong
    public function actionSendMailCalculateCostToyota() {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $key_send_mail = isset($_POST['key_send_mail']) ? $_POST['key_send_mail'] : '';
        if($email && $key_send_mail) {
            $data = $_SESSION[$key_send_mail];
            // Send mail
            $subject = 'Dự toán chi phí';
            $content = $this->renderPartial('mail/mail-calculate-costToyota', $data, true);
            if(Yii::app()->mailer->send('', $email, $subject, $content)) {
                echo 'Thông tin đã được gửi đến email của quý khách.';
                return;
            }
        }
        echo 'Không thể gửi thông tin.';
        return;
    }

    public function actionSetRegion() {
        if (Yii::app()->request->isAjaxRequest) {
            $region = (int) Yii::app()->request->getParam('region', 0);
            $car_id = (int) Yii::app()->request->getParam('car_id', 0);
            $keyRegion = self::KEY_CAR_REGION . $car_id;
            $_SESSION[$keyRegion] = $region;
            $_SESSION['car_id'] = $car_id;
            $this->jsonResponse(200, array(
                'redirect' => $this->createUrl('/car/buycar/calculateCostToyotaStep3'),
            ));
        }
    }

    public function actionSetColor() {
        if (Yii::app()->request->isAjaxRequest) {
            $color = (int) Yii::app()->request->getParam('color', 0);
            $car_id = (int) Yii::app()->request->getParam('car_id', 0);
            $keyColor = self::KEY_CAR_COLOR . $car_id;
            $_SESSION[$keyColor] = $color;
            $this->jsonResponse(200);
        }
    }

    public function actionAddAccessory() {
        if (Yii::app()->request->isAjaxRequest) {
            $accessory_id = (int) Yii::app()->request->getParam('accessory_id', 0);
            $type = (int) Yii::app()->request->getParam('type', 0);
            $car_id = $_SESSION['car_id'];
            if ($accessory_id) {
                $keyAccessory = self::KEY_CAR_ACCESSORY . $car_id;
                $accessoriesIds = $_SESSION[$keyAccessory];
                if (isset($accessoriesIds) && $accessoriesIds) {
                    $ids = json_decode($accessoriesIds, true);
                    if ($type == 1) {
                        $ids[$accessory_id] = $accessory_id;
                        $_SESSION[$keyAccessory] = json_encode($ids);
                    } else {
                        unset($ids[$accessory_id]);
                        $_SESSION[$keyAccessory] = json_encode($ids);
                    }
                } else {
                    $ids = [$accessory_id => $accessory_id];
                    $_SESSION[$keyAccessory] = json_encode($ids);
                }
            }
            $this->jsonResponse(200);
        }
    }

    public function actionSupportBuycar() {

        $cid = Yii::app()->request->getParam('cid', 0);
        $vid = Yii::app()->request->getParam('vid', 0);

        $versions = array();
        if ($cid) {
            $versions = CarVersions::getAllVersions($cid, 'id, name');
        }
        $cars = Car::getAllCar('id, name');

        $this->render('support_buycar', array(
            'cars' => $cars,
            'cid' => $cid,
            'versions' => $versions,
            'vid' => $vid
        ));
    }

    public function actionGetVersion() {
        $car_id = Yii::app()->request->getParam('car_id', 0);
        $car = Car::model()->findByPk($car_id);
        if (!$car) {
            $this->sendResponse(404);
        }
        if ($car->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        $html_version = '<option value="">--Tất cả--</option>';
        if ($car) {
            $versions = CarVersions::getAllVersions($car_id, 'id, name');
            if (count($versions)) {
                foreach ($versions as $version) {
                    $html_version .= '<option value="' . $version['id'] . '">' . $version['name'] . '</option>';
                }
            }
        }
        $this->jsonResponse(200, array(
            'html' => $html_version
        ));
    }

    public function actionCal() {
        $car_id = Yii::app()->request->getParam('car_id', 0);
        $version_id = Yii::app()->request->getParam('version_id', 0);
        $interest = Yii::app()->request->getParam('interest', 0);
        $first_price = Yii::app()->request->getParam('first_price', 0);
        $month = Yii::app()->request->getParam('month', 0);

        if ($car_id && $version_id && $interest && $first_price && $month) {
            $price = 0;
            $array_month = range(1, $month, 1);
            $array_money = array();

            $version = CarVersions::model()->findByPk($version_id);
            $price += round(($version->price / 100) * (100 - $first_price));

            $principal = round($price / $month);

            foreach ($array_month as $v) {
                $array_money[$v]['principal'] = $principal; // Tiền gốc phải nộp mỗi tháng
                $array_money[$v]['recover_money'] = round($price - $principal); // Dư nợ
                $array_money[$v]['interest'] = round(($price / 100) * $interest); // Tiền lãi
                $array_money[$v]['sum_printcipal_interest'] = $array_money[$v]['principal'] + $array_money[$v]['interest']; // Tiền gốc + lãi
                $price = $array_money[$v]['recover_money'];
            }

            $html = $this->renderPartial('cal_html', array(
                'array_money' => $array_money
            ), true);
            $this->jsonResponse(200, array(
                'html' => $html
            ));
        } else {
            $this->sendResponse(404);
        }
    }

    public function toNmuber($string) {
        if($string) {
            $string = str_replace('.', '', $string);
            return (int) $string;
        }
        return 0;
    }

    //cong
    public function actionCaltoyata() {
        $car_id = Yii::app()->request->getParam('car_id', 0);
        $car_suport_type = Yii::app()->request->getParam('car_suport_type', 1);
        $month = Yii::app()->request->getParam('car_suport_year', 0)*12;
        $car_earnest = $this->toNmuber(Yii::app()->request->getParam('car_earnest', 0));
        $car_price = $this->toNmuber(Yii::app()->request->getParam('car_price', 0));
        $car_component_price = $this->toNmuber(Yii::app()->request->getParam('car_component_price', 0));
        $total_price = $car_price + $car_component_price;
        $interest = CarSuport::optionInterests()[$car_suport_type];
        switch ($car_suport_type) {
            case 1:
                if ($car_id && $car_earnest && $total_price && $month) {
                    $price = $total_price - $car_earnest;
                    $array_month = range(1, $month, 1);
                    $array_money = array();
                    $principal = round($price / $month);
                    foreach ($array_month as $v) {
                        $array_money[$v]['principal'] = $principal; // Tiền gốc phải nộp mỗi tháng
                        $array_money[$v]['recover_money'] = round($price - $principal); // Dư nợ
                        $array_money[$v]['interest'] = round((($price / 100) * $interest)/$month); // Tiền lãi
                        $array_money[$v]['sum_printcipal_interest'] = $array_money[$v]['principal'] + $array_money[$v]['interest']; // Tiền gốc + lãi
                        $price = $array_money[$v]['recover_money'];
                    }

                    echo $html = $this->renderPartial('caltoyata_html', array(
                        'array_money' => $array_money
                    ), true);
                } else {
                    $this->sendResponse(404);
                }
                break;
            case 2:
                if ($car_id && $car_earnest && $total_price ) {
                    $principal = $total_price - $car_earnest;
                    $interest =  $principal*$interest/100;
                    echo $html = $this->renderPartial('caltoyata_html_t2', array(
                        'array_money' => [
                            'principal' => $principal,
                            'interest' => $interest,
                            'sum_printcipal_interest' => $principal + $interest,
                        ]
                    ), true);
                }
                break;
            default:
                $this->sendResponse(404);
                break;
        }
    }

    public function actionCalGeneral() {
        $car_id = Yii::app()->request->getParam('car_id', 0);
        $version_id = Yii::app()->request->getParam('version_id', 0);
        $interest = Yii::app()->request->getParam('interest', 0);
        $first_price = Yii::app()->request->getParam('first_price', 0);
        $month = Yii::app()->request->getParam('month', 0);

        if ($car_id && $version_id && $interest && $first_price && $month) {
            $price = 0;
            $array_month = range(1, $month, 1);
            $array_money = array();

            $version = CarVersions::model()->findByPk($version_id);
            $price += round(($version->price / 100) * (100 - $first_price));

            $principal = round($price / $month);

            foreach ($array_month as $v) {
                $array_money[$v]['principal'] = $principal; // Tiền gốc phải nộp mỗi tháng
                $array_money[$v]['recover_money'] = round($price - $principal); // Dư nợ
                $array_money[$v]['interest'] = round(($price / 100) * $interest); // Tiền lãi
                $array_money[$v]['sum_printcipal_interest'] = $array_money[$v]['principal'] + $array_money[$v]['interest']; // Tiền gốc + lãi
                $price = $array_money[$v]['recover_money'];
            }

            $html = $this->renderPartial('cal_general_html', array(
                'array_money' => $array_money,
                'version' => $version
            ), true);
            $this->jsonResponse(200, array(
                'html' => $html
            ));
        } else {
            $this->sendResponse(404);
        }
    }

    public function actionEstimate() {
        $car_id = Yii::app()->request->getParam('car_id', 0);
        $version_id = Yii::app()->request->getParam('version_id', 0);
        $regional_id = Yii::app()->request->getParam('regional_id', 0);
        if ($version_id && $regional_id && $car_id) {
            $price = 0;
            $number_plate_fee = 0; // chi phí đăng ký
            $registration_fee_percent = 0; // Lệ phí trước bạ
            $version = CarVersions::model()->findByPk($version_id);
            if ($version) {
                $price += $version->price;
            }

            $regional = CarReceiptFee::model()->findByPk($regional_id);
            if ($regional) {
                $number_plate_fee = $regional->number_plate_fee;
                $registration_fee_percent = $this->getPriceBonusPercent($price, $regional->registration_fee);
            }

            $total_price = $price + $number_plate_fee + $registration_fee_percent + $regional->inspection_fee + $regional->road_toll + $regional->insurance_fee;

            $car = Car::model()->findByPk($car_id);

            $html = $this->renderPartial('estimate_html', array(
                'total_price' => $total_price,
                'price' => $price,
                'number_plate_fee' => $number_plate_fee,
                'registration_fee_percent' => $registration_fee_percent,
                'version' => $version,
                'regional' => $regional,
                'car' => $car
            ), true);

            $this->jsonResponse(200, array(
                'html' => $html,
            ));
        } else {
            $this->sendResponse(404);
        }
    }

    public function actionEstimateDetail() {
        $car_id = Yii::app()->request->getParam('car_id', 0);
        $version_id = Yii::app()->request->getParam('version_id', 0);
        $regional_id = Yii::app()->request->getParam('regional_id', 0);
        if ($version_id && $regional_id && $car_id) {
            $price = 0;
            $number_plate_fee = 0; // chi phí đăng ký
            $registration_fee_percent = 0; // Lệ phí trước bạ
            $version = CarVersions::model()->findByPk($version_id);
            if ($version) {
                $price += $version->price;
            }

            $regional = CarReceiptFee::model()->findByPk($regional_id);
            if ($regional) {
                $number_plate_fee = $regional->number_plate_fee;
                $registration_fee_percent = $this->getPriceBonusPercent($price, $regional->registration_fee);
            }

            $total_price = $price + $number_plate_fee + $registration_fee_percent + $regional->inspection_fee + $regional->road_toll + $regional->insurance_fee;

            $car = Car::model()->findByPk($car_id);

            $html = $this->renderPartial('estimate_detail_html', array(
                'total_price' => $total_price,
                'price' => $price,
                'number_plate_fee' => $number_plate_fee,
                'registration_fee_percent' => $registration_fee_percent,
                'version' => $version,
                'regional' => $regional,
                'car' => $car
            ), true);

            $this->jsonResponse(200, array(
                'html' => $html,
            ));
        } else {
            $this->sendResponse(404);
        }
    }

    public function actionEstimateNow() {
        $car_id = Yii::app()->request->getParam('car_id', 0);
        $version_id = Yii::app()->request->getParam('version_id', 0);
        $regional_id = Yii::app()->request->getParam('regional_id', 0);
        if ($version_id && $regional_id && $car_id) {
            $price = 0;
            $number_plate_fee = 0; // chi phí đăng ký
            $registration_fee_percent = 0; // Lệ phí trước bạ
            $version = CarVersions::model()->findByPk($version_id);
            if ($version) {
                $price += $version->price;
            }

            $regional = CarReceiptFee::model()->findByPk($regional_id);
            if ($regional) {
                $number_plate_fee = $regional->number_plate_fee;
                $registration_fee_percent = $this->getPriceBonusPercent($price, $regional->registration_fee);
            }

            $total_price = $price + $number_plate_fee + $registration_fee_percent + $regional->inspection_fee + $regional->road_toll + $regional->insurance_fee;
            $total_fee = $number_plate_fee + $registration_fee_percent + $regional->inspection_fee + $regional->road_toll + $regional->insurance_fee;

            $car = Car::model()->findByPk($car_id);

            $html = $this->renderPartial('estimate_now_html', array(
                'total_price' => $total_price,
                'total_fee' => $total_fee,
                'price' => $price,
                'number_plate_fee' => $number_plate_fee,
                'registration_fee_percent' => $registration_fee_percent,
                'version' => $version,
                'regional' => $regional,
                'car' => $car
            ), true);

            $this->jsonResponse(200, array(
                'html' => $html,
            ));
        } else {
            $this->sendResponse(404);
        }
    }

    public function getPriceBonusPercent($price, $percent) {
        return round(($price / 100) * $percent);
    }

    //cong
    public function actionSupportBuyToyota() {
        $this->layout = '//layouts/support_buy_toyota';
        $cars = Car::getAllCar('*');
        $components['year'] = CarSuport::optionYears();
        $components['type'] = CarSuport::optionTypes();
        $components['interest'] = CarSuport::optionInterests();
        $components['earn_min_type'] = CarSuport::optionEarnMin();
        $components['payment_method'] = CarSuport::optionPaymentMethods();
        $this->render('support_buytoyota', array(
            'data' => $cars,
            'components' => $components
        ));
    }
    //cong
    public function actionSendMailSuportBuy() {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        if($email) {
            $model = new CarHistorySuportBuy();
            $model->email = $email;
            $model->name = $name;
            $model->car_id =  isset($_POST['car_id']) ? $_POST['car_id'] : 0;
            $model->car_price =  isset($_POST['car_price']) ? $this->toNmuber($_POST['car_price']) : 0;
            $model->car_name = ($car = Car::model()->findByPk($model->car_id)) ? $car->name : '';
            $color_id = isset($_POST['car_color_id']) ? $_POST['car_color_id'] : 0;

            if($car_color = CarColors::model()->findByPk($color_id)) {
                $model->car_color = $car_color->code_color.'.'.$car_color->name;
                $model->car_avatar = $car_color->avatar;
            }
            $model->car_component_price =  isset($_POST['car_component_price']) ? $this->toNmuber($_POST['car_component_price']) : '';
            $model->car_earnest = isset($_POST['car_earnest']) ? $this->toNmuber($_POST['car_earnest']) : 0;
            $model->car_suport_type =  isset($_POST['car_suport_type']) ? $_POST['car_suport_type'] : '';
            $model->month =  isset($_POST['car_suport_year']) ? $_POST['car_suport_year']*12 : 0;
            $model->interest =  CarSuport::optionInterests()[$model->car_suport_type];
            $model->created_time = time();
            $model->site_id = Yii::app()->controller->site_id;
            $model->save(false);

            // Send mail
            $total_price = $model->car_price + $model->car_component_price;
            $interest = $model->interest;
            $month = $model->month;
            $car_earnest = $model->car_earnest;
            $html = '';
            switch ($model->car_suport_type) {
                case 1:
                    if ($model->car_id && $car_earnest && $total_price && $month) {
                        $price = $total_price - $car_earnest;
                        $array_month = range(1, $month, 1);
                        $array_money = array();
                        $principal = round($price / $month);
                        foreach ($array_month as $v) {
                            $array_money[$v]['principal'] = $principal; // Tiền gốc phải nộp mỗi tháng
                            $array_money[$v]['recover_money'] = round($price - $principal); // Dư nợ
                            $array_money[$v]['interest'] = round((($price / 100) * $interest)/$month); // Tiền lãi
                            $array_money[$v]['sum_printcipal_interest'] = $array_money[$v]['principal'] + $array_money[$v]['interest']; // Tiền gốc + lãi
                            $price = $array_money[$v]['recover_money'];
                        }
                        $html = $this->renderPartial('caltoyata_html', array(
                            'array_money' => $array_money
                        ), true);
                    }
                    break;
                case 2:
                    if ($model->car_id && $car_earnest && $total_price ) {
                        $principal = $total_price - $car_earnest;
                        $interest =  $principal*$interest/100;
                        $html = $this->renderPartial('caltoyata_html_t2', array(
                            'array_money' => [
                                'principal' => $principal,
                                'interest' => $interest,
                                'sum_printcipal_interest' => $principal + $interest,
                            ]
                        ), true);
                    }
                    break;
            }
            $subject = 'Hỗ trợ tài chính';
            $content = $this->renderPartial('mail/mail-suportbuy', [
                'html' => $html,
                'model' => $model
            ], true);
            if(Yii::app()->mailer->send('', $email, $subject, $content)) {
                echo 'Thông tin đã được gửi đến email của quý khách.';
                return;
            }
        }
        echo 'Không thể gửi thông tin.';
        return;
    }

}

?>