<?php

class TimekeepingController extends PublicController
{

    public $layout = '//layouts/timekeeping';

    function actionShow($id)
    {
        $view = 'index';
        $t = Yii::app()->request->getParam('t', 0);
        if (isset($t) && $t == 1) {
            $view = 'index_new';
        }
        $model = Timekeeping::model()->findByPk($id);

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
        require_once Yii::getPathOfAlias("webroot") . "/common/extensions/php-excel/PHPExcel.php";
        //
        $importinfo["excelfile"] = Yii::getPathOfAlias("webroot") . '/mediacenter' . $model->filepath;
        //
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
                if (isset($t) && $t) {
                    if ($i == 4) {
                        $subscriberinfo[$i] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($subscriberinfo[$i]));
                        $subscriberinfo[$day] = date('D', strtotime($subscriberinfo[$i]));
                    } else if ($i == 6) {
                        $subscriberinfo[$i] = PHPExcel_Style_NumberFormat::toFormattedString($subscriberinfo[$i], 'hh:mm');
                    } else if ($i == 7) {
                        $subscriberinfo[$i] = PHPExcel_Style_NumberFormat::toFormattedString($subscriberinfo[$i], 'hh:mm');
                    } else {
                        if (!is_string($subscriberinfo[$i]) && !is_numeric($subscriberinfo[$i]) && $subscriberinfo[$i] != NULL) {
                            $subscriberinfo[$i] = $subscriberinfo[$i]->getPlainText();
                        }
                        $subscriberinfo[$i] = trim(str_replace(array('&nbsp;'), '', htmlentities($subscriberinfo[$i])));
                        $subscriberinfo[$i] = html_entity_decode($subscriberinfo[$i]);
                    }
                } else {
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
            }
            $data[] = $subscriberinfo;
        }
        $count_data = count($data);
        //
        $result = [];
        foreach ($data as $key => $item) {
            // check $key > 0 (không phải là header)
            if ($key > 0) {
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
                        $result_final[$tennv][$option['date']] = $option;
                    } else {
                        $option['morning'] = 0;
                        $option['afternoon'] = 0;
                        $result_final[$tennv][$option['date']] = $option;
                    }
                }
            }
        }
        //
        //

        $this->render($view, array(
            'importinfo' => $importinfo,
            'result_final' => $result_final,
            'model' => $model
        ));
    }

}
