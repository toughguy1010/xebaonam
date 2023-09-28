<?php

class OfficeController extends PublicController
{

    public function actionEstimateCost()
    {
        $this->layoutForAction = '//layouts/office_estimate_cost';
        //
        $model = new OfficeEstimateCost();
        //
        $categories = OfficeEstimateCost::optionCategories();
        //
        $floors = OfficeEstimateCost::optionFloor();
        //
        $ceilings = OfficeEstimateCost::optionCeiling();
        //
        $qualities = OfficeEstimateCost::optionQuality();
        //
        $model->area = 90; // default area
        $model->staff = 10; // default staff
        $model->table_manager = 1; // default table manager
        $model->quality = 1; // default table manager
        $model->floor = 1; // default table manager
        //
        $product_images = [];
        $flat_images = [];
        $aryCost = [];
        if (isset($_POST['OfficeEstimateCost'])) {
            $inputInfo = $model->attributes = $_POST['OfficeEstimateCost'];
            //Calculator package
            if ($model->validate()) {
                // 1- Giá sàn
                $aryCost['package']['floorPrice'] = 1.05 * $model->area * OfficeEstimateCost::optionFloorPrices()[$model->floor];

                // 2 - Trần
                $aryCost['package']['ceilingPrice'] = 1.05 * $model->area * OfficeEstimateCost::optionCeilingPrices()[$inputInfo['ceiling']];

                // Sơn bả tường
                $aryCost['package']['wallPaint'] = round(OfficeEstimateCost::optionQualityPercent()[$model->quality] * sqrt($model->area) * 4 * 3.2 * 1.8 * 70000);

                // Vách ngăn
                $aryCost['package']['officePartition'] = round(OfficeEstimateCost::optionQualityPercent()[$model->quality] * $model->area / 12 * (3 + 2) * 1.3 * 250000);

                // 	Cửa đi và cửa sổ
                $aryCost['package']['doorsAndWindows'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * $model->area / 33 * 1.2 * 2.2 * 1500000 + $model->area / 50 * 1.4 * 1.4 * 1300000;

                // Rèm trong văn phòng
                $aryCost['package']['curtains'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * round(sqrt($model->area) * 1200000);

                // Điện và chiếu sáng
                $aryCost['package']['electricityAndLighting'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * $model->area / 100 * 15000000;

                // Hệ thống mạng và điện thoại
                $aryCost['package']['networkAndTelephoneSystems'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * $inputInfo['staff'] * 1000000;

                // Vách ngăn phòng họp và phòng lãnh đạo
                $aryCost['package']['partitionMeetingRoomAndLeadershipRoom'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * $model->table_manager * (3 + 5) * 2 * 3 * 260000;

                //Phòng họp vách kính

                $aryCost['package']['glassWall'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * $inputInfo['room_meeting'] * (3 + 6) * 3 * 1250000;
                /*Quầy lễ tân*/

                $aryCost['furniture']['reception'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * ($inputInfo['reception']) ? 12000000 : 0;

                /*Bàn ghế tiếp khách tại lễ tân*/
                $aryCost['furniture']['receptionDesk'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * 10000000;

                /*Bàn và ghế làm việc*/
                $aryCost['furniture']['deskAndChair'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * ($inputInfo['staff'] + 1) * 1050000 + ($inputInfo['staff'] + 3) * 650000;

                /*Bàn ghế lãnh đạo*/
                $aryCost['furniture']['leaderChairs'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * $model->table_manager * (3000000 + 5000000) + $model->table_manager * 2 * 2000000 + $model->table_manager * 500000;

                //Bàn và ghế phòng họp
                $aryCost['furniture']['meetingRoomTableAndChairs'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * $inputInfo['room_meeting'] * (5000000 + 6 * 650000) * (ceil($model->staff) / 50);

                //Tủ đựng tài liệu
                $aryCost['furniture']['fileCabinet'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * ceil($inputInfo['staff'] / 3) * 2000000;

                /* Két sắt*/
                $aryCost['furniture']['safe'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * 3000000;

                //Other
                if (count($aryCost['package'])) {
                    $packagePrice = 0;
                    foreach ($aryCost['package'] as $value) {
                        $packagePrice += (float)$value;
                    }
                }

                //
                if (count($aryCost['furniture'])) {
                    $furniturePrice = 0;
                    foreach ($aryCost['furniture'] as $value) {
                        $furniturePrice += (float)$value;
                    }
                }

                /*Chi phí khác (bảng hiệu, đèn, đèn trang trí…)*/
                $aryCost['other']['other'] = round(OfficeEstimateCost::optionQualityPercent()[$model->quality] * ($furniturePrice + $packagePrice) * 10 / 100);

                /*Chi phí vận chuyển*/
                $aryCost['other']['transportationCostsAndCleaningCosts'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * round(($aryCost['other']['other'] + ($furniturePrice + $packagePrice)) * 1 / 100);

                /*Chi phí thiết kế*/
                $aryCost['other']['designCosts'] = OfficeEstimateCost::optionQualityPercent()[$model->quality] * $model->area * 100000;

                if (count($aryCost['other'])) {
                    $otherPrice = 0;
                    foreach ($aryCost['other'] as $value) {
                        $otherPrice += (float)$value;
                    }
                }

                $model->result = json_encode($aryCost);
                $model->total_price = ($otherPrice + $furniturePrice + $packagePrice);
                if ($model->save()) {
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'office_notice',
                    ));
                    if ($mailSetting) {
                        //Hiện ra danh sách sản phẩm được chọn.
                        $data = array(
                            'link' => '<a href="' . Yii::app()->createAbsoluteUrl('economy/office/printEstimateCost', array('id' => $model->id)) . '">Link</a>',
                            'category' => $categories[$model->cid],
                            'area' => $model->area,
                            'staff' => $model->staff,
                            'name' => $model->name,
                            'email' => $model->email,
                            'mobile' => $model->phone,
                            'total_price' => number_format($model->total_price, 0, '', ',')
                        );
                        //
                        $content = $mailSetting->getMailContent($data);
                        //
                        $subject = $mailSetting->getMailSubject($data);
                        //
                        if ($content && $subject) {
                            Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                        }
                    }
                };

                if ($model->save()) {
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'customer_office_notice',
                    ));
                    if ($mailSetting) {
                        //Hiện ra danh sách sản phẩm được chọn.
                        $data = array(
                            'link' => '<a href="' . Yii::app()->createAbsoluteUrl('economy/office/printEstimateCost', array('id' => $model->id)) . '">Link</a>',
                            'category' => $categories[$model->cid],
                            'area' => $model->area,
                            'staff' => $model->staff,
                            'name' => $model->name,
                            'email' => $model->email,
                            'mobile' => $model->phone,
                            'total_price' => number_format($model->total_price, 0, '', ',')
                        );
                        //
                        $content = $mailSetting->getMailContent($data);
                        //
                        $subject = $mailSetting->getMailSubject($data);
                        //
                        if ($content && $subject) {
                            Yii::app()->mailer->send('', $model->email, $subject, $content);
                        }
                    }
                };
            }
            if ($model->view_product) {
                $product_images = OfficeImages::getOfficeImages(['area' => $model->area], false);
            }
            if ($model->view_flat) {
                $flat_images = OfficeImages::getOfficeImages(['area' => $model->area], true);
            }
        }
        //

        $this->render('estimate_cost', [
            'model' => $model,
            'categories' => $categories,
            'floors' => $floors,
            'ceilings' => $ceilings,
            'qualities' => $qualities,
            'aryCost' => $aryCost,
            'product_images' => $product_images,
            'flat_images' => $flat_images
        ]);
    }

    public function actionPrintEstimateCost($id)
    {
        $this->layoutForAction = '//layouts/office_estimate_cost';
        //
        $model = new OfficeEstimateCost();

        $model = $model::model()->findByPk($id);

        if (!$model) {
            $this->sendResponse(404);
        }
        $aryCost = json_decode($model->result, true);

        $categories = OfficeEstimateCost::optionCategories();
        //
        $floors = OfficeEstimateCost::optionFloor();
        //
        $ceilings = OfficeEstimateCost::optionCeiling();
        //
        $qualities = OfficeEstimateCost::optionQuality();

        //
        if ($model->view_product) {
            $product_images = OfficeImages::getOfficeImages(['area' => $model->area], false);
        }
        if ($model->view_flat) {
            $flat_images = OfficeImages::getOfficeImages(['area' => $model->area], true);
        }

        $this->renderPartial('print_estimate_cost', [
            'model' => $model,
            'categories' => $categories,
            'floors' => $floors,
            'ceilings' => $ceilings,
            'qualities' => $qualities,
            'aryCost' => $aryCost,
            'product_images' => $product_images,
            'flat_images' => $flat_images
        ]);
    }

}
