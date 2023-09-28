<?php

class CandidateController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->breadcrumbs = array(
            Yii::t('work', 'candidate_manager') => Yii::app()->createUrl('/work/candidate'),
            Yii::t('work', 'candidate_create') => Yii::app()->createUrl('/work/candidate/create'),
        );
        $model = new Candidate();
        $model->unsetAttributes();
        $model->site_id = $this->site_id;
        //
        if (isset($_POST['Candidate'])) {
            $model->attributes = $_POST['Candidate'];
            //
            if ($model->validate(null, false)) {
                if ($model->save(false)) {
                    $this->redirect(Yii::app()->createUrl('/work/candidate'));
                }
            }
            //
            // if ($model->save())
            //     $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $this->breadcrumbs = array(
            Yii::t('work', 'candidate_manager') => Yii::app()->createUrl('/work/candidate'),
            Yii::t('work', 'candidate_update') => Yii::app()->createUrl('/work/candidate/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['Candidate'])) {
            $model->attributes = $_POST['Candidate'];
            //
            $model->site_id = $this->site_id;
            //
            if ($model->validate(null, false)) {
                //
                if ($model->save(false)) {
                    $this->redirect(Yii::app()->createUrl('/work/candidate'));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {

        $model = new Candidate();
        $model = $model->findByPk($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionDeleteall()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int)sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $model = new Jobs();
                    if (ClaSite::getLanguageTranslate()) {
                        $model->setTranslate(true);
                        //
                    }
                    $model = $model->findByPk($ids[$i]);
                    if ($model->site_id == $this->site_id) {
                        $model->delete();
                    }
                }
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->breadcrumbs = array(
            Yii::t('work', 'candidate') => Yii::app()->createUrl('/work/candidate'),
        );
        $model = new Candidate();
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['Candidate'])) {
            $model->attributes = $_GET['Candidate'];
        }
        $provinces = LibProvinces::getListProvinceArr();
        //
        $this->render('index', array(
            'model' => $model,
            'provinces' => $provinces,
        ));
    }

    public function actionListApply()
    {
        $this->breadcrumbs = array(
            Yii::t('work', 'list_apply') => Yii::app()->createUrl('/work/jobs/listApply'),
        );
        $model = new JobApply();
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['Jobs'])) {
            $model->attributes = $_GET['Jobs'];
        }
        $this->render('list_apply', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Jobs the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Candidate::model()->findByPk($id);
        //
        if ($model === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($model->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Jobs $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'jobs-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * upload file
     */
    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'jobs'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public function allowedActions()
    {
        return 'uploadfile';
    }

    /**
     * Import product from excel
     */
    public function actionImportExcel()
    {
        $this->breadcrumbs = array(
            Yii::t('product', 'product_manager') => Yii::app()->createUrl('/economy/product'),
            Yii::t('product', 'product_create') => Yii::app()->createUrl('/economy/product/create'),
        );

        $importinfo = array();
        $field_list = array();
        $field_list['country'] = 'Cột quốc gia';
        $field_list['work_type'] = 'Cột lĩnh vực';
        $field_list['name'] = 'Cột họ tên';
        $field_list['year_of_birth'] = 'Cột năm sinh';
        $field_list['sex'] = 'Cột giới tính';
        $field_list['province'] = 'Cột địa chỉ';
        $field_list['phone'] = 'Cột số điện thoại';

        $postfield = Yii::app()->request->getPost('postfield');
        $excelfile = Yii::app()->request->getPost('excelfile');

        // read and write data from excel
        if (Yii::app()->request->isPostRequest && $postfield && $excelfile) {
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
                for ($i = 0; $i < $col; $i++) {
                    if (!is_string($subscriberinfo[$i]) && !is_numeric($subscriberinfo[$i]) && $subscriberinfo[$i] != NULL) {
                        $subscriberinfo[$i] = $subscriberinfo[$i]->getPlainText();
                    }
                    $subscriberinfo[$i] = trim(str_replace(array('&nbsp;'), '', htmlentities($subscriberinfo[$i])));
                    $subscriberinfo[$i] = html_entity_decode($subscriberinfo[$i]);
                }
                $data[] = $subscriberinfo;
            }

            $count_data = count($data);
            if ($count_data) {
                $trades = (new Trades())->options(['key' => 'trade_name', 'value' => 'trade_id']);
                $countries = (new JobsCountry())->options(['key' => 'name', 'value' => 'id']);
                foreach ($data as $key => $item) {
                    if ($key > 1) {
                        $model = Candidate::model()->findByAttributes(array(
                                'site_id' => $this->site_id,
                                'phone' => $item[$postfield['phone']]
                            )
                        );
                        if ($model === NULL) {
                            $model = new Candidate();
                            $model->country_text = $item[$postfield['country']];
                            $model->work_type_text = $item[$postfield['work_type']];
                            $model->address = $item[$postfield['province']];
                            $model->work_type_id = $model->country_id = $model->province_id = 0;
                            if(isset($trades[$model->work_type_text]) && $trades[$model->work_type_text]) {
                                $model->work_type_id = $trades[$model->work_type_text];
                            }
                            if(isset($countries[$model->country_text]) && $countries[$model->country_text]) {
                                $model->country_id = $countries[$model->country_text];
                            }

                            $model->name = $item[$postfield['name']];
                            $model->year_of_birth = $item[$postfield['year_of_birth']];
                            $model->sex = $item[$postfield['sex']];
                            $model->phone = $item[$postfield['phone']];
                            $model->save();
                        }
                    }
                }
                $this->redirect(Yii::app()->createUrl("/work/candidate/index"));
            }
        }

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
        }


        $this->render('import_excel', array(
            'importinfo' => $importinfo,
            'field_list' => $field_list
        ));
    }

    /**
     * Export order to csv
     * @author: HungTM
     * @edit Hatv
     */
    public function actionExportcsv()
    {
        $arrFields = array('ID', 'Quốc gia', 'Lĩnh vực', 'Họ tên', 'Năm sinh', 'Giới tính', 'Địa chỉ', 'Số điện thoại');
        $string = implode("\t", $arrFields) . "\n";
        //
        $command = Yii::app()->db->createCommand();
        $select = '*';
        $command->select($select)
            ->from('candidate')
            ->order('id DESC');
        //
        $candidates = $command->queryAll();
        foreach ($candidates as $candidate) {
            $phone = $candidate['phone'];
            $arr = array(
                $candidate['id'],
                $candidate['country'],
                $candidate['work_type'],
                $candidate['name'],
                $candidate['year_of_birth'],
                $candidate['sex'],
                $candidate['province'],
                $phone,
            );
            $string .= implode("\t", $arr) . "\n";
        }
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . Yii::app()->siteinfo['domain_default'] . "_" . Date('dmY_hsi') . ".csv");
        header("Content-Transfer-Encoding: binary");
        $string = chr(255) . chr(254) . mb_convert_encoding($string, 'UTF-16LE', 'UTF-8');
        echo $string;
    }

}
