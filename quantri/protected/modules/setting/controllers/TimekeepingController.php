<?php

class TimekeepingController extends BackController {

    public function actionList() {
        $this->breadcrumbs = array(
            'Quản lý chấm công' => Yii::app()->createUrl('setting/timekeeping/list'),
        );
        $model = new Timekeeping('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Timekeeping'])) {
            $model->attributes = $_GET['Timekeeping'];
        }

        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            'Quản lý chấm công' => Yii::app()->createUrl('setting/timekeeping/list'),
            'Tạo mới' => Yii::app()->createUrl('setting/timekeeping/create'),
        );
        //
        $model = new Timekeeping;
        $model->scenario = 'create';
        if (isset($_POST['Timekeeping'])) {
            $model->attributes = $_POST['Timekeeping'];
            $file = $_FILES['filepath'];
            if ($model->save()) {
                if ($file) {
                    $up = new UploadLib($file);
                    $up->setPath(array('timekeeping', date('m-Y')));
                    $up->uploadFile();
                    $response = $up->getResponse(true);
                    if ($up->getStatus() == '200') {
                        $model->filepath = $response['baseUrl'] . $response['name'];
                        $model->save();
                    }
                }
                $this->redirect(Yii::app()->createUrl('setting/timekeeping/list'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $this->breadcrumbs = array(
            'Quản lý chấm công' => Yii::app()->createUrl('setting/timekeeping/list'),
            'Cập nhật' => Yii::app()->createUrl('setting/timekeeping/update'),
        );
        $model = Timekeeping::model()->findByPk($id);
        if (isset($_POST['Timekeeping'])) {
            $model->attributes = $_POST['Timekeeping'];
            $file = $_FILES['filepath'];
            if ($model->save()) {
                if ($file) {
                    $up = new UploadLib($file);
                    $up->setPath(array('timekeeping', date('m-Y')));
                    $up->uploadFile();
                    $response = $up->getResponse(true);
                    if ($up->getStatus() == '200') {
                        $model->filepath = $response['baseUrl'] . $response['name'];
                        $model->save();
                    }
                }
                $this->redirect(Yii::app()->createUrl('setting/timekeeping/list'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 
     */
    public function actionIndex() {
        $this->breadcrumbs = array(
            'Xuất file excel' => Yii::app()->createUrl('/setting/timekeeping/index'),
        );
        //
        $importinfo = array();
        //
        $code = 1;
        $name = 2;
        $date = 4;
        $checkin = 6;
        $checkout = 7;
        $day = 100;
        $days = [
            2 => 'Mon',
            3 => 'Tue',
            4 => 'Wed',
            5 => 'Thu',
            6 => 'Fri',
            7 => 'Sat',
            8 => 'Sun',
        ];
        //
        //
        if (Yii::app()->request->isPostRequest) {
            require_once Yii::getPathOfAlias("webroot") . "/../common/extensions/php-excel/PHPExcel.php";

            $excelfile = $_FILES["ExcelFile"];
            $newfilename = 'importExcel-' . md5(uniqid(rand(), true) . time());
            $uploadstatus = move_uploaded_file($excelfile['tmp_name'], Yii::getPathOfAlias("webroot") . '/uploads/excels' . '/' . $newfilename);

            if (!$uploadstatus) {
                echo 'Upload không thành công';
                return false;
            } else {
                $importinfo["excelfile"] = Yii::getPathOfAlias("webroot") . '/uploads/excels' . '/' . $newfilename;
            }
            try {
                $objReader = new PHPExcel_Reader_Excel2007();
                $objPHPExcel = $objReader->load($importinfo["excelfile"]);
            } catch (Exception $e) {
                die;
            }
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10        // Lấy index của dòng cuối cùng
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'  // lấy index của ô ngoài cùng
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5 // Số thứ tự ngoài ngoài cùng trong một dòng


            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $importinfo["ImportList"][] = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
            }
            $importinfo["TotalSubscribers"] = $highestRow;
            //
            // process data
            $data = array();
            for ($row = 1; $row <= $highestRow; $row++) {
                $subscriberinfo = array();
                for ($col = 0; $col < $highestColumnIndex; $col++) {
                    $subscriberinfo[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }
                for ($i = 0; $i < $col; $i++) {
                    if ($i == 4) {
                        $subscriberinfo[$i] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($subscriberinfo[$i]));
                        $subscriberinfo[$day] = date('D', strtotime($subscriberinfo[$i]));
                    } else {
                        if (!is_string($subscriberinfo[$i]) && !is_numeric($subscriberinfo[$i]) && $subscriberinfo[$i] != NULL) {
                            $subscriberinfo[$i] = $subscriberinfo[$i]->getPlainText();
                        }
                        $subscriberinfo[$i] = trim(str_replace(array('&nbsp;'), '', htmlentities($subscriberinfo[$i])));
                        $subscriberinfo[$i] = html_entity_decode($subscriberinfo[$i]);
                    }
                }
                $data[] = $subscriberinfo;
            }
            $count_data = count($data);
            //
            $result = [];
            foreach ($data as $key => $item) {
                // check $key > 0 (không phải là header)
                if ($key > 2) {
                    $result[] = [
                        'code' => $item[$code],
                        'name' => $item[$name],
                        'date' => $item[$date],
                        'day' => $item[$day],
                        'checkin' => $item[$checkin],
                        'checkout' => $item[$checkout],
                    ];
                }
            }
            $data_process = [];
            if ($count_data) {
                foreach ($result as $re) {
                    $data_process[$re['name']][] = $re;
                }
            }
            $result_final = [];
            $onehour = 3600;
            $alldays = [];
            if ($data_process) {
                foreach ($data_process as $tennv => $options) {
                    foreach ($options as $option) {
                        if ($option['checkin'] && $option['checkout']) {
                            $timeBreakOne = strtotime('12:00:00');
                            $timeBreakTwo = strtotime('13:30:00');
                            $checkin = strtotime($option['checkin']);
                            $checkout = strtotime($option['checkout']);
                            //
                            $option['morning'] = 0;
                            $option['afternoon'] = 0;
                            //
                            if ($checkin && $checkin < $timeBreakOne) {
                                if ($checkout >= $timeBreakOne) {
                                    $option['morning'] = gmdate('H:i', $timeBreakOne - $checkin);
                                } else {
                                    $option['morning'] = gmdate('H:i', $checkout - $checkin);
                                }
                            }
                            //
                            if ($checkout && $checkout > $timeBreakTwo) {
                                if ($checkin <= $timeBreakTwo) {
                                    $option['afternoon'] = gmdate('H:i', $checkout - $timeBreakTwo);
                                } else {
                                    $option['afternoon'] = gmdate('H:i', $checkout - $checkin);
                                }
                            }
                            //
                            $result_final[$tennv][] = $option;
                        } else {
                            $option['morning'] = 0;
                            $option['afternoon'] = 0;
                            $result_final[$tennv][] = $option;
                        }
                    }
                }
            }
            //
        }
        //
        $this->render('index', array(
            'importinfo' => $importinfo,
            'result_final' => $result_final
        ));
        //
    }

}
