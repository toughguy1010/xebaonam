<?php

class ExpertransContactController extends BackController
{

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new ExpertransContactFormModel;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ExpertransContactFormModel'])) {
            $model->attributes = $_POST['ExpertransContactFormModel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->contact_id));
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
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ExpertransContactFormModel'])) {
            $model->attributes = $_POST['ExpertransContactFormModel'];
            if ($model->save()){
                $this->redirect(array('index'));
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new ExpertransContactFormModel();
        $model->unsetAttributes();
        $model->site_id = Yii::app()->controller->site_id;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new ExpertransContactFormModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ExpertransContactFormModel']))
            $model->attributes = $_GET['ExpertransContactFormModel'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ExpertransContactFormModel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ExpertransContactFormModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ExpertransContactFormModel $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'contacts-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * export order to csv
     */
    public
    function actionExportcsv()
    {
        $arrFields = array('Khách hàng', 'Email', 'Số điện thoại','Dịch vụ', 'Đơn giá', 'Đơn vị tiền tệ', 'Công ty', 'Sdt công ty', 'Phương thức thanh toán', 'Tình trạng thanh toán', 'Trạng thái', 'Thời gian tạo', 'Người giới thiệu', '% hoa hồng');
        $string = implode("\t", $arrFields) . "\n" . "\n";

        $TranslateOrder = Yii::app()->db->createCommand()
            ->select('*')
            ->from('expertrans_contact_form t')
            ->where('t.site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->order('t.id DESC')
            ->queryAll();
        $status = BpoForm::getStatusArr();

        foreach ($TranslateOrder as $order) {
            $user = Users::model()->findByPk($order['affiliate_user']);
            $arr = array(
                $order['name'],
                $order['email'],
                "=\"" . (string)$order['phone'] . "\"",
                ExpertransService::model()->findByPk($order['service'])->name ,
                $order['total_price'],
                $order['currency'],
                $order['company_name'],
                $order['company'],
                TranslateOrder::getPaymentMethod()[$order['payment_method']],
                TranslateOrder::getPaymentStatus()[$order['payment_status']],
                $status[$order['status']],
                "=\"" . date('d-m-Y H:i:s', $order['created_time']) . "\"",
                ($user) ? $user->name : '',
                ($user) ? $order['aff_percent'] : '',
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

    /**
     * Xóa các sản phẩm được chọn
     */
    public
    function actionDeleteall()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int)sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $model = $this->loadModel($ids[$i]);
                    if ($model->site_id == $this->site_id) {
                        $model->delete();
                    }
                }
            }
        }
    }


}
