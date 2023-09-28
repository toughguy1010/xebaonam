<?php

class NewsletterController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->breadcrumbs = array(
            Yii::t('news', 'newsletter') => Yii::app()->createUrl('content/newsletter'),
            Yii::t('common', 'create') => Yii::app()->createUrl('/content/newsletter/create'),
        );
        //
        $model = new Newsletters;
        $model->site_id = $this->site_id;
        //
        if (isset($_POST['Newsletters'])) {
            $model->attributes = $_POST['Newsletters'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'createsuccess'));
                $this->redirect(Yii::app()->createUrl('content/newsletter'));
            }
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
    public function actionUpdate($id) {
        $this->breadcrumbs = array(
            Yii::t('news', 'newsletter') => Yii::app()->createUrl('content/newsletter'),
            Yii::t('common', 'update') => Yii::app()->createUrl('/content/newsletter/update', array('id' => $id)),
        );
        ///
        $model = $this->loadModel($id);
        //
        if (isset($_POST['Newsletters'])) {
            $model->attributes = $_POST['Newsletters'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                $this->redirect(Yii::app()->createUrl('content/newsletter'));
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
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->breadcrumbs = array(
            Yii::t('news', 'newsletter') => Yii::app()->createUrl('content/newsletter'),
        );
        $model = new Newsletters('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Newsletters']))
            $model->attributes = $_GET['Newsletters'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Delete all
     */
    public function actionDeleteall() {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int) sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $this->loadModel($ids[$i])->delete();
                }
            }
        }
    }

    /**
     * 
     */
    public function actionExportcsv() {
        $newsletter = new Newsletters();
        $all = Newsletters::getAllNewsletter();
        $string = implode(',', array($newsletter->getAttributeLabel('name'), $newsletter->getAttributeLabel('email'), $newsletter->getAttributeLabel('created_time'))) . "\n";
        foreach ($all as $ne) {
            $string.=implode(',', array($ne['name'], $ne['email'], date('d-m-Y H:i:s', $ne['created_time']))) . "\n";
        }
        //
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . Yii::app()->siteinfo['domain_default'] . "_" . Date('dmY_hsi') . ".csv");
        header("Content-Transfer-Encoding: binary");
        echo "\xEF\xBB\xBF";
        //
        echo $string;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Newsletters the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Newsletters::model()->findByPk($id);
        if ($model === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($model->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model->oldMail = $model->email;
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Newsletters $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'newsletters-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
