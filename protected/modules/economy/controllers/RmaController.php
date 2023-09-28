<?php

class RmaController extends PublicController
{
    public $layout = '//layouts/rma';
    /**
     *  Form
     */
    function actionIndex()
    {
        $model = new RmaCompanyInfomation();
        $modelItems[] = new RmaItems();
        if (Yii::app()->request->isPostRequest) {
            $companyInfomation = Yii::app()->request->getPost('RmaCompanyInfomation');
            $aryRmaItems = Yii::app()->request->getPost('RmaItems');
            $model->attributes = $companyInfomation;
            $itemValidate = true;
            if (count($aryRmaItems)) {
                foreach ($aryRmaItems as $key => $value) {
                    if (($key != 0)) {
                        $modelItems[$key] = new RmaItems();
                    }
                    $modelItems[$key]->attributes = $value;
                    if (!$modelItems[$key]->validate()) {
                        $itemValidate = false;
                    }
                }
            }
            if ($model->validate() && $itemValidate) {
                $model->key = ClaGenerate::getUniqueCode(array('prefix' => 'o'));
                if ($model->save()) {
                    foreach ($modelItems as $key => $value) {
                        $value->site_id = Yii::app()->controller->site_id;
                        $value->rma_id = $model->id;
                        $value->save();
                    }
                }
                $this->redirect(Yii::app()->createUrl('/economy/rma/complete', array('id' => $model->id, 'key' => $model->key)));
            }
        }
        //
        $this->render('index', array(
            'model' => $model,
            'modelItems' => $modelItems,
        ));
    }

    /**
     * Show customer order
     * @param $id
     */
    function actionComplete($id)
    {
        $key = Yii::app()->request->getParam('key');
        $model = RmaCompanyInfomation::model()->findByPk($id);
        if ($model->key != $key) {
            $this->sendResponse(404);
        }
        $this->render('complete', array(
            'model' => $model,
        ));
    }
}