<?php

class SmsCustomerController extends BackController {

    const VIETTEL_KEY = 'VIETTEL';
    const VINAPHONE_KEY = 'VINA';
    const MOBIFONE_KEY = 'MOBIFONE';
    const OTHER_KEY = 'OTHER';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->breadcrumbs = array(
            Yii::t('sms', 'customer') => Yii::app()->createUrl('/sms/smsCustomer/'),
            Yii::t('sms', 'customer_create') => Yii::app()->createUrl('/sms/smsCustomer/create'),
        );
        $model = new SmsCustomer();
        $group_id_get = Yii::app()->request->getParam('group_id', 0);
        if ($group_id_get) {
            $model->group_id = $group_id_get;
        }

        $post = Yii::app()->request->getPost('SmsCustomer');
        $site_id = Yii::app()->controller->site_id;
        $dn = 5;
        $sms_customer = array();

        if (Yii::app()->request->isPostRequest && $post) {
            $sms_customer = $post;
            $group_id = $post['group_id'];
            $model->group_id = $group_id;
            unset($post['group_id']);
            if ($group_id == '') {
                $model->addError('group_id', 'Bạn phải chọn nhóm liên hệ');
            }
            if (count($post)) {
                $dn = count($post);
                $value = '';
                $data = $post;
                $time = time();
                foreach ($data as $key => $item) {
                    $i++;
                    $alias = HtmlFormat::parseToAlias($item['name']);
                    $phone = preg_replace("/[^0-9+]/", "", $item['phone']);
                    $provider_key = SmsProvider::getServiceProvider($phone);
                    $name = $item['name'];
                    if ($name != '' && $phone != '') {
                        if ($value != '') {
                            $value .= ',';
                        }
                        $value .= "('" . $phone . "', '" . $name . "', '" . $alias . "', '" . $group_id . "', '" . $time . "', '" . $time . "', '" . $site_id . "', '" . $provider_key . "')";
                    }
                }
                if ($value == '') {
                    $model->addError('empty_name_phone', 'Bạn phải nhập đầy đủ ít nhất 1 liên hệ');
                }
                if (!$model->hasErrors()) {
                    $sql = 'INSERT INTO sms_customer(phone, name, alias, group_id, created_time, modified_time, site_id, provider_key) VALUES' . $value . ' ON DUPLICATE KEY UPDATE name = VALUES(name)';
                    Yii::app()->db->createCommand($sql)->execute();
                    $this->redirect(Yii::app()->createUrl("/sms/smsCustomerGroup/view", array('id' => $group_id)));
                }
            }
        }
        $option_group = SmsCustomer::getOptionCustomerGroup();
        $this->render('add', array(
            'model' => $model,
            'option_group' => $option_group,
            'dn' => $dn,
            'sms_customer' => $sms_customer
        ));
    }

    public function actionCreateFromExcel() {

        $this->breadcrumbs = array(
            Yii::t('sms', 'customer') => Yii::app()->createUrl('/sms/smsCustomer/'),
            Yii::t('sms', 'customer_create_from_excel') => Yii::app()->createUrl('/sms/smsCustomer/createFromExcel'),
        );
        $model = new SmsCustomer();
        $group_id_get = Yii::app()->request->getParam('group_id', 0);
        if ($group_id_get) {
            $model->group_id = $group_id_get;
        }
        $importinfo = array();
        $field_list = array();
        $field_list['phone'] = 'Cột chứa số di động';
        $field_list['name'] = 'Cột chứa tên khách hàng';

        $post = Yii::app()->request->getPost('SmsCustomer');
        $postfield = Yii::app()->request->getPost('postfield');
        $excelfile = Yii::app()->request->getPost('excelfile');

        // read and write data from excel
        if (Yii::app()->request->isPostRequest && $postfield && $excelfile && $post['group_id']) {
            require_once Yii::getPathOfAlias("webroot") . "/../common/extensions/php-excel/PHPExcel.php";
            try {
                $objReader = new PHPExcel_Reader_Excel2007();
                $objPHPExcel = $objReader->load($excelfile);
            } catch (Exception $e) {
                echo 'có lỗi xảy ra khi đọc file dữ liệu';
                die;
            }
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10        // Lấy index của dòng cuối cùng
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'  // lấy index của ô ngoài cùng
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5 // Số thứ tự ngoài ngoài cùng trong một dòng

            $data = array();
            for ($row = 1; $row <= $highestRow; $row++) {
                $subscriberinfo = array();
                for ($col = 0; $col < $highestColumnIndex; $col++) {
                    $subscriberinfo[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }
                $data[$subscriberinfo[$postfield['phone']]] = $subscriberinfo;
            }

            $count_contact = count($data);

            if ($count_contact) {
                $value = '';
                $i = 0;
                $group_id = $post['group_id'];
                $time = time();
                $site_id = Yii::app()->controller->site_id;
                foreach ($data as $key => $item) {
                    $i++;
                    $phone = preg_replace("/[^0-9+]/", "", $item[$postfield['phone']]);
                    $provider_key = SmsProvider::getServiceProvider($phone);
                    $name = (isset($item[$postfield['name']]) && $item[$postfield['name']] != '') ? $item[$postfield['name']] : 'NN';
                    $alias = HtmlFormat::parseToAlias($item[$postfield['name']]);
                    if (strlen($phone) >= 9 && strlen($phone) <= 12) {
                        if ($value) {
                            $value .= ',';
                        }
                        $value .= "('" . $phone . "', '" . $name . "', '" . $alias . "', '" . $group_id . "', '" . $time . "', '" . $time . "', '" . $site_id . "', '" . $provider_key . "')";
                    }
                }

                $count_group = Yii::app()->db->createCommand()
                        ->select('count(*)')
                        ->from(ClaTable::getTable('sms_customer'))
                        ->where('site_id=:site_id AND group_id=:group_id', array(':site_id' => Yii::app()->controller->site_id, 'group_id' => $post['group_id']))
                        ->queryScalar();
                $sql = 'INSERT IGNORE INTO sms_customer(phone, name, alias, group_id, created_time, modified_time, site_id, provider_key) VALUES' . $value;
                Yii::app()->db->createCommand($sql)->execute();
                $this->redirect(Yii::app()->createUrl("/sms/smsCustomerGroup/view", array('id' => $group_id)));
            }
        }

        if (Yii::app()->request->isPostRequest && $post) {
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
            $model->group_id = $post['group_id'];
        }

        $option_group = SmsCustomer::getOptionCustomerGroup();

        $this->render('add_from_excel', array(
            'model' => $model,
            'option_group' => $option_group,
            'importinfo' => $importinfo,
            'field_list' => $field_list
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->breadcrumbs = array(
            Yii::t('sms', 'customer') => Yii::app()->createUrl('/sms/smsCustomer/'),
            Yii::t('sms', 'customer_update') => Yii::app()->createUrl('/sms/smsCustomer/update'),
        );
        $model = $this->loadModel($id);

        $post = Yii::app()->request->getPost('SmsCustomer');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $provider_key = SmsProvider::getServiceProvider($model->phone);
            $model->provider_key = $provider_key;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/sms/smsCustomerGroup/view", array('id' => $model->group_id)));
            }
        }
        $option_group = SmsCustomer::getOptionCustomerGroup();
        $this->render('update', array(
            'model' => $model,
            'option_group' => $option_group
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        $model = SmsCustomer::model()->findByPk($id);
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

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('sms', 'customer') => Yii::app()->createUrl('/sms/smsCustomer'),
        );

        $model = new SmsCustomer();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SmsCustomer'])) {
            $model->attributes = $_GET['SmsCustomer'];
        }
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CourseCategories the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SmsCustomer::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CourseCategories $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sms-customer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function getGroupName($id) {
        $model = SmsCustomerGroup::model()->findByPk($id);
        if ($model) {
            return $model->name;
        }
        return '';
    }

    public function actionDeleteall() {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id) {
                Yii::app()->end();
            }
            $ids = explode(",", $list_id);
            $count = (int) sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $model = $this->loadModel($ids[$i]);
                    $model->delete();
                }
            }
        }
    }

}
